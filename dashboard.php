<?php
session_start();
if(!isset($_SESSION["logged_in"])){ header("Location: login.php"); exit; }

$host = '127.0.0.1';
$db   = 'medios_core_db';
$user = 'medios_admin';
$pass = '@Pegapalo22$$Core';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // --- ENTERPRISE DEPLOYMENT ENGINE (NOW WITH DEPARTMENTS) ---
    $success_msg = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'deploy') {
        $raw_name = trim($_POST['company_name']);
        $tier = $_POST['tier'];
        $did = preg_replace('/[^0-9]/', '', $_POST['did']);
        $depts = (int)$_POST['departments']; // How many departments?
        
        $prefix = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', explode(' ', $raw_name)[0]));
        $context = $prefix . "-main";
        
        if(!empty($prefix) && !empty($did)) {
            // 1. Build Base Menu
            $sql_ivr = "INSERT INTO extensions (context, exten, priority, app, appdata) VALUES 
            ('$context', 's', 1, 'Answer', ''),
            ('$context', 's', 2, 'Set', 'CHANNEL(language)=en'),
            ('$context', 's', 3, 'Background', 'custom/{$prefix}-welcome'),
            ('$context', 's', 4, 'WaitExten', '10')";
            
            // 2. Dynamically add Departments (Sales, Support, Billing, etc.)
            $dept_names = ['sales', 'support', 'billing', 'service', 'admin'];
            for($i = 1; $i <= $depts; $i++) {
                $dname = $dept_names[$i-1];
                $sql_ivr .= ", ('$context', '$i', 1, 'Dial', 'SIP/{$prefix}-$dname,20')";
                $sql_ivr .= ", ('$context', '$i', 2, 'VoiceMail', '{$prefix}{$dname}@default,u')";
                $sql_ivr .= ", ('$context', '$i', 3, 'Hangup', '')";
            }
            
            // 3. Map the Phone Number
            $sql_route = "INSERT INTO incoming_routing (did, destination_context, description) VALUES ('$did', '$context', '$raw_name')";
            
            $pdo->beginTransaction();
            $pdo->exec($sql_ivr);
            $pdo->exec($sql_route);
            $pdo->commit();
            
            $success_msg = "<strong>Success!</strong> {$raw_name} deployed on +1{$did} with {$depts} departments.";
        }
    }

    $stmt = $pdo->query("SELECT t1.context, t2.did FROM extensions t1 LEFT JOIN incoming_routing t2 ON t1.context = t2.destination_context WHERE t1.exten='s' AND t1.priority=1");
    $raw_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $tenants = [];
    $name_map = ['mc' => 'Medios Corporativos', 'mcs' => 'McIntosh Cleaning', 'pronto' => 'Pronto Painting', 'prowork' => 'Prowork Painting'];

    foreach($raw_data as $row) {
        $ctx = $row['context'];
        $base_name = explode('-', $ctx)[0];
        $pretty_name = isset($name_map[$base_name]) ? $name_map[$base_name] : ucfirst($base_name);
        if(!isset($tenants[$base_name])) {
            $tenants[$base_name] = [
                'name' => $pretty_name,
                'did' => $row['did'] ? $row['did'] : 'No DID Assigned',
                'tier' => (count($tenants) % 2 == 0) ? 'Elite' : 'Growth',
                'color' => (count($tenants) % 2 == 0) ? 'purple' : 'blue'
            ];
        }
    }
    $company_count = count($tenants);
    
} catch (\PDOException $e) {
    if (isset($pdo) && $pdo->inTransaction()) { $pdo->rollBack(); }
    die("Database Error: " . $e->getMessage());
}

$name = $_SESSION['username'];
date_default_timezone_set('America/Chicago'); 
$hour = date('H');
if ($hour < 12) { $greeting = "Good Morning"; $icon = "bi-sunrise text-warning"; } 
elseif ($hour < 18) { $greeting = "Good Afternoon"; $icon = "bi-sun text-warning"; } 
else { $greeting = "Good Evening"; $icon = "bi-moon-stars text-primary"; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Medios Core | Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap');
        body { background-color: #f1f5f9; font-family: 'Inter', sans-serif; color: #0f172a; }
        .sidebar { height: 100vh; background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%); color: white; padding-top: 30px; }
        .sidebar .brand { font-size: 1.4rem; font-weight: 800; padding: 0 20px 30px; display: flex; align-items: center; gap: 10px;}
        .sidebar a { color: #94a3b8; text-decoration: none; padding: 14px 25px; display: flex; align-items: center; font-weight: 600; transition: 0.3s; border-left: 4px solid transparent; }
        .sidebar a:hover, .sidebar a.active { background: rgba(255,255,255,0.05); color: #fff; border-left: 4px solid #3b82f6; }
        .page-header { background: #fff; padding: 25px 40px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); margin-bottom: 30px;}
        .stat-card { background: #fff; border-radius: 16px; padding: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.02); transition: 0.3s; }
        .tenant-card { background: #fff; border-radius: 20px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.04); position: relative; overflow: hidden; height: 100%;}
        .tenant-card::before { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 5px; background: #e2e8f0; }
        .tenant-card.blue::before { background: #3b82f6; }
        .tenant-card.purple::before { background: #a855f7; }
        .btn-gradient { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; border: none; border-radius: 10px; padding: 12px 25px; font-weight: bold;}
    </style>
</head>
<body>
    <div class="container-fluid p-0">
        <div class="row g-0">
            <div class="col-md-2 sidebar position-fixed">
                <div class="brand"><i class="bi bi-hexagon-fill text-primary"></i> Medios Core</div>
                <a href="dashboard.php" class="active"><i class="bi bi-grid-fill me-2"></i> Dashboard</a>
                <a href="audio.php"><i class="bi bi-mic-fill me-2"></i> Audio Studio</a>
            </div>
            <div class="col-md-10 offset-md-2 p-5">
                <?php if($success_msg): ?><div class="alert alert-success rounded-4"><i class="bi bi-check-circle-fill me-2"></i><?= $success_msg ?></div><?php endif; ?>
                
                <div class="page-header d-flex justify-content-between align-items-center">
                    <div><h2 class="fw-bold mb-1"><i class="bi <?= $icon ?> me-2"></i><?= $greeting ?>, <?= htmlspecialchars($name) ?>.</h2></div>
                    <button class="btn btn-gradient" data-bs-toggle="modal" data-bs-target="#deployModal"><i class="bi bi-plus-lg me-2"></i> Deploy New Client</button>
                </div>

                <div class="row g-4 mb-5">
                    <div class="col-md-4"><div class="stat-card p-4"><h3><?= $company_count ?></h3><small class="fw-bold text-muted">ACTIVE TENANTS</small></div></div>
                    <div class="col-md-4"><div class="stat-card p-4"><h3 class="text-success">Live</h3><small class="fw-bold text-muted">REALTIME ENGINE</small></div></div>
                    <div class="col-md-4"><div class="stat-card p-4"><h3>Secure</h3><small class="fw-bold text-muted">VAULT STATUS</small></div></div>
                </div>

                <div class="row g-4">
                    <?php foreach($tenants as $t): ?>
                    <div class="col-md-4">
                        <div class="tenant-card <?= $t['color'] ?>">
                            <span class="badge bg-light text-dark rounded-pill mb-3 fw-bold"><?= $t['tier'] ?> Tier</span>
                            <h4 class="fw-bold"><?= $t['name'] ?></h4>
                            <p class="text-muted small fw-bold"><i class="bi bi-phone me-1"></i> DID: +1 <?= $t['did'] ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deployModal" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg p-3">
          <form method="POST">
            <input type="hidden" name="action" value="deploy">
            <h4 class="fw-bold mb-4">Deploy Enterprise</h4>
            
            <div class="mb-3"><label class="small fw-bold text-muted">COMPANY NAME</label>
            <input type="text" name="company_name" class="form-control bg-light border-0" required></div>
            
            <div class="mb-3"><label class="small fw-bold text-muted">SUBSCRIPTION TIER</label>
            <select name="tier" class="form-select bg-light border-0" id="tierSelect">
                <option value="Starter">Starter (Max 1 Dept)</option>
                <option value="Growth">Growth (Max 3 Depts)</option>
                <option value="Elite">Elite (Unlimited/5 Depts)</option>
            </select></div>

            <div class="mb-3"><label class="small fw-bold text-muted">DEPARTMENTS (IVR OPTIONS)</label>
            <select name="departments" class="form-select bg-light border-0">
                <option value="1">1 Department (Press 1)</option>
                <option value="2">2 Departments (Press 1, 2)</option>
                <option value="3">3 Departments (Press 1, 2, 3)</option>
                <option value="4">4 Departments (Press 1, 2, 3, 4)</option>
                <option value="5">5 Departments (Press 1 to 5)</option>
            </select></div>
            
            <div class="mb-4"><label class="small fw-bold text-muted">TELNYX DID</label>
            <input type="text" name="did" class="form-control bg-light border-0" placeholder="2815551234" required></div>
            
            <button type="submit" class="btn btn-gradient w-100 py-2">Launch Engine</button>
          </form>
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
