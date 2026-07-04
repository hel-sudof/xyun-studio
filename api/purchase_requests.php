<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db.php';

// Admin check
if (!isAdmin()) {
    header('Location: login.php');
    exit;
}

$purchases = [];
try {
    $purchases = dbFetchAll("SELECT * FROM purchases ORDER BY timestamp DESC");
} catch (Exception $e) {
    $purchases = [];
}

// Fallback: sample purchase requests if database is empty
if (empty($purchases)) {
    $purchases = [
        [
            'id' => 'REQ-001',
            'timestamp' => '2026-07-04 10:30:00',
            'product_id' => '03',
            'product_name' => 'DESIGN 03',
            'items' => json_encode([
                ['price' => 'HIGH NECK TOP (Rp 1.380.000) - RC/T-003'],
                ['price' => 'BAGGY JEANS (Rp 1.920.000) - RC/P-002']
            ]),
            'customer' => json_encode([
                'name' => 'Alex Rivera',
                'email' => 'alex.rivera@email.com',
                'phone' => '+62 811 2233 4455',
                'notes' => 'I am 175cm tall. Please ensure the jeans have a relaxed fit. Would love expedited shipping if possible.'
            ]),
            'status' => 'Pending'
        ],
        [
            'id' => 'REQ-002',
            'timestamp' => '2026-07-03 21:42:18',
            'product_id' => '05',
            'product_name' => 'DESIGN 05',
            'items' => json_encode([
                ['price' => 'DOUBLE VEST (Rp 1.010.000) - RC/T-001'],
                ['price' => 'BAGGY JEANS (Rp 1.670.000) - RC/P-001']
            ]),
            'customer' => json_encode([
                'name' => 'Natasha L.',
                'email' => 'natasha.l@studio.com',
                'phone' => '+44 7911 123456',
                'notes' => 'Rush order please — I need this before July 15th for a fashion event. Willing to pay extra for shipping.'
            ]),
            'status' => 'Pending'
        ],
        [
            'id' => 'REQ-003',
            'timestamp' => '2026-07-03 14:30:05',
            'product_id' => '02',
            'product_name' => 'DESIGN 02',
            'items' => json_encode([
                ['price' => 'OFF SHOULDER TOP (Rp 1.275.000) - RC/T-002'],
                ['price' => 'RUFFLE SKIRT (Rp 915.000) - RC/S-001']
            ]),
            'customer' => json_encode([
                'name' => 'Aria Stark',
                'email' => 'aria.s@example.com',
                'phone' => '+65 9123 4567',
                'notes' => ''
            ]),
            'status' => 'Accepted'
        ],
        [
            'id' => 'REQ-004',
            'timestamp' => '2026-07-03 09:15:22',
            'product_id' => '01',
            'product_name' => 'DESIGN 01',
            'items' => json_encode([
                ['price' => 'HIGH NECK TOP (Rp 1.245.000) - RC/T-005'],
                ['price' => 'BAGGY JEANS (Rp 1.890.000) - RC/P-003']
            ]),
            'customer' => json_encode([
                'name' => 'Jane Doe',
                'email' => 'janedoe@example.com',
                'phone' => '+62 812 3456 7890',
                'notes' => 'I am 170cm tall, please make sure the pants are long enough to cover the ankles. Thank you!'
            ]),
            'status' => 'Declined'
        ]
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>xyún studio | PURCHASE REQUESTS</title>
  <link rel="stylesheet" href="style.css">
  <style>
    html, body {
      overflow-y: auto !important;
      height: auto !important;
    }
    .page-container {
      height: auto !important;
      overflow: visible !important;
      display: block !important;
    }
    
    .page-header {
      text-align: center;
      padding: 80px 0 60px 0;
      background-image: url('bg/reqbg.jpg');
      background-size: cover;
      background-position: center;
      position: relative;
    }
    .page-header::before {
      content: "";
      position: absolute;
      inset: 0;
      background-color: rgba(0, 0, 0, 0.7);
      z-index: 1;
    }
    .page-header > * {
      position: relative;
      z-index: 2;
    }
    
    .page-title {
      font-family: var(--font-nuqun);
      font-size: 48px;
      letter-spacing: 0.15em;
      color: #ffffff;
      margin-bottom: 12px;
    }
    
    .page-subtitle {
      font-size: 12px;
      color: #ffffff;
      letter-spacing: 0.1em;
      text-transform: uppercase;
    }

    .requests-container {
      padding: 60px 48px 80px 48px;
      max-width: 1200px;
      margin: 0 auto;
    }

    .request-card {
      background-color: var(--zinc-900);
      border: 1px solid var(--zinc-700);
      box-shadow: 0 4px 20px rgba(0,0,0, 0.5);
      padding: 24px;
      margin-bottom: 24px;
      transition: border-color 0.3s ease;
    }
    
    .request-card:hover {
      border-color: var(--zinc-500);
    }

    .req-header {
      display: flex;
      justify-content: space-between;
      border-bottom: 1px solid var(--zinc-800);
      padding-bottom: 16px;
      margin-bottom: 16px;
    }

    .req-id {
      font-family: var(--font-nuqun);
      font-size: 18px;
      color: #ffffff;
      letter-spacing: 0.1em;
    }

    .req-time {
      font-size: 12px;
      color: var(--zinc-500);
    }

    .req-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 24px;
    }
    
    @media (max-width: 768px) {
      .req-grid {
        grid-template-columns: 1fr;
      }
    }

    .req-section h4 {
      font-size: 11px;
      color: var(--zinc-500);
      margin-bottom: 12px;
      letter-spacing: 0.1em;
    }

    .req-section p {
      font-size: 13px;
      color: var(--zinc-300);
      margin-bottom: 8px;
      line-height: 1.5;
    }
    
    .req-section strong {
      color: #ffffff;
    }

    .req-items {
      list-style: none;
      padding: 0;
      margin: 0;
    }
    .req-items li {
      font-size: 13px;
      color: var(--zinc-300);
      padding: 8px 0;
      border-bottom: 1px solid var(--zinc-900);
    }
    .req-items li:last-child {
      border-bottom: none;
    }

    .status-badge {
      font-size: 11px;
      padding: 4px 10px;
      border-radius: 4px;
      text-transform: uppercase;
      font-weight: bold;
      letter-spacing: 0.1em;
    }
    .status-pending { background-color: var(--zinc-800); color: var(--zinc-300); }
    .status-accepted { background-color: #166534; color: #ffffff; }
    .status-declined { background-color: #991b1b; color: #ffffff; }
    
    .action-btns {
      margin-top: 24px;
      display: flex;
      gap: 12px;
      border-top: 1px solid var(--zinc-800);
      padding-top: 16px;
    }
    .btn-action {
      background: none;
      border: 1px solid var(--zinc-600);
      color: #ffffff;
      padding: 8px 16px;
      font-size: 11px;
      letter-spacing: 0.1em;
      cursor: pointer;
      transition: all 0.2s ease;
    }
    .btn-accept:hover { background-color: #166534; border-color: #166534; }
    .btn-decline:hover { background-color: #991b1b; border-color: #991b1b; }

  </style>
</head>
<body class="animate-fade-in">

  <?php include 'header.php'; ?>

  <div class="page-container">
    <div class="page-header">
      <h1 class="page-title">REQUESTS</h1>
      <p class="page-subtitle">INCOMING PURCHASE ORDERS</p>
    </div>

    <div class="requests-container">
      <?php if (empty($purchases)): ?>
        <div style="text-align: center; color: var(--zinc-500); padding: 60px 0;">
          <p>NO PURCHASE REQUESTS YET.</p>
        </div>
      <?php else: ?>
        <?php foreach ($purchases as $req): 
            $status = isset($req['status']) ? $req['status'] : 'Pending';
            $status_class = 'status-pending';
            if ($status === 'Accepted') $status_class = 'status-accepted';
            if ($status === 'Declined') $status_class = 'status-declined';
            
            // Decode JSONB fields from PostgreSQL
            $customer = is_string($req['customer']) ? json_decode($req['customer'], true) : $req['customer'];
            $items = is_string($req['items']) ? json_decode($req['items'], true) : $req['items'];
            if (!is_array($customer)) $customer = [];
            if (!is_array($items)) $items = [];
        ?>
          <div class="request-card" id="card-<?php echo htmlspecialchars($req['id']); ?>">
            <div class="req-header">
              <div>
                <div class="req-id">#<?php echo htmlspecialchars($req['id']); ?></div>
                <div class="req-time"><?php echo htmlspecialchars($req['timestamp']); ?></div>
              </div>
              <div>
                <span class="status-badge <?php echo $status_class; ?>" id="status-<?php echo htmlspecialchars($req['id']); ?>"><?php echo htmlspecialchars($status); ?></span>
              </div>
            </div>
            
            <div class="req-grid">
              <div class="req-section">
                <h4>CUSTOMER DETAILS</h4>
                <p><strong>Name:</strong> <?php echo htmlspecialchars($customer['name'] ?? ''); ?></p>
                <p><strong>Email:</strong> <a href="mailto:<?php echo htmlspecialchars($customer['email'] ?? ''); ?>" style="color: var(--zinc-300); text-decoration: underline;"><?php echo htmlspecialchars($customer['email'] ?? ''); ?></a></p>
                <p><strong>Phone:</strong> <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $customer['phone'] ?? ''); ?>" target="_blank" style="color: var(--zinc-300); text-decoration: underline;"><?php echo htmlspecialchars($customer['phone'] ?? ''); ?></a></p>
                <?php if(!empty($customer['notes'])): ?>
                  <div style="margin-top: 16px; padding: 12px; background: rgba(255,255,255,0.03); border-left: 2px solid var(--zinc-700);">
                    <p style="margin-bottom:0; font-size: 12px; font-style: italic;">"<?php echo nl2br(htmlspecialchars($customer['notes'])); ?>"</p>
                  </div>
                <?php endif; ?>
              </div>
              
              <div class="req-section">
                <h4>ORDER DETAILS</h4>
                <p><strong>Product:</strong> <?php echo htmlspecialchars($req['product_name']); ?> (ID: <?php echo htmlspecialchars($req['product_id']); ?>)</p>
                <div style="margin-top: 12px;">
                  <ul class="req-items">
                    <?php foreach($items as $item): ?>
                      <li>- <?php echo htmlspecialchars($item['price'] ?? $item['name'] ?? ''); ?></li>
                    <?php endforeach; ?>
                  </ul>
                </div>
              </div>
            </div>
            
            <div class="action-btns" id="actions-<?php echo htmlspecialchars($req['id']); ?>" style="display: <?php echo $status === 'Pending' ? 'flex' : 'none'; ?>">
              <button class="btn-action btn-accept" onclick="updateStatus('<?php echo htmlspecialchars($req['id']); ?>', 'accept')">ACCEPT REQUEST</button>
              <button class="btn-action btn-decline" onclick="updateStatus('<?php echo htmlspecialchars($req['id']); ?>', 'decline')">DECLINE</button>
            </div>
            
            <div class="action-btns" id="undo-<?php echo htmlspecialchars($req['id']); ?>" style="display: <?php echo $status !== 'Pending' ? 'flex' : 'none'; ?>">
              <button class="btn-action" onclick="updateStatus('<?php echo htmlspecialchars($req['id']); ?>', 'undo')">UNDO ACTION</button>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>

  <script>
    function updateStatus(id, action) {
      if (!confirm('Are you sure you want to ' + action + ' this request?')) return;
      
      fetch('purchase_status.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: id, action: action })
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          // Update badge UI
          const badge = document.getElementById('status-' + id);
          badge.textContent = data.new_status;
          
          if (data.new_status === 'Pending') {
            badge.className = 'status-badge status-pending';
            document.getElementById('actions-' + id).style.display = 'flex';
            document.getElementById('undo-' + id).style.display = 'none';
          } else if (data.new_status === 'Accepted') {
            badge.className = 'status-badge status-accepted';
            document.getElementById('actions-' + id).style.display = 'none';
            document.getElementById('undo-' + id).style.display = 'flex';
          } else {
            badge.className = 'status-badge status-declined';
            document.getElementById('actions-' + id).style.display = 'none';
            document.getElementById('undo-' + id).style.display = 'flex';
          }
        } else {
          alert('Error: ' + data.error);
        }
      })
      .catch(err => alert('Network error occurred.'));
    }
  </script>
</body>
</html>
