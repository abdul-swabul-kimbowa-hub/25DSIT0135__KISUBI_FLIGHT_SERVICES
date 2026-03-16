<?php
$page_title = 'Baggage | Kisubi Airlines';
require_once __DIR__ . '/partials/header.php';
?>

<main class="section">
    <h1 class="section-title">Baggage information</h1>

    <div style="display:grid; grid-template-columns:minmax(0,1.2fr) minmax(0,0.8fr); gap:18px; align-items:start;">
        <div class="glass-panel" style="padding:18px;">
            <h2 style="margin-top:0; font-size:1rem;">Cabin baggage</h2>
            <p style="color:#64748b; margin-top:6px;">
                Carry-on allowances depend on your cabin and fare. Always keep valuables, medicines, and documents in your cabin bag.
            </p>
            <ul style="margin-top:10px;">
                <li>1 carry-on bag + 1 personal item (typical)</li>
                <li>Liquids: follow airport security rules</li>
                <li>Oversized items may be checked at the gate</li>
            </ul>

            <h2 style="font-size:1rem; margin-top:18px;">Checked baggage</h2>
            <p style="color:#64748b; margin-top:6px;">
                Checked baggage rules vary by route and fare type. If you need extra bags, you can purchase excess baggage at the airport.
            </p>
            <ul style="margin-top:10px;">
                <li>Standard allowance by fare (Economy/Business/First)</li>
                <li>Weight limits apply; excess fees may apply</li>
                <li>Label your bag clearly with your contact info</li>
            </ul>

            <h2 style="font-size:1rem; margin-top:18px;">Special items</h2>
            <ul style="margin-top:10px;">
                <li>Sports equipment: pack securely and declare at check-in</li>
                <li>Musical instruments: may require a special seat or handling</li>
                <li>Baby items: strollers may be checked at the gate</li>
            </ul>

            <h2 style="font-size:1rem; margin-top:18px;">Restricted items</h2>
            <p style="color:#64748b; margin-top:6px;">
                Dangerous goods (flammables, certain batteries, chemicals) are restricted. Check airport and airline rules before travel.
            </p>
        </div>

        <div class="glass-panel" style="padding:18px;">
            <h2 style="margin-top:0; font-size:1rem;">Baggage assistance</h2>
            <p style="color:#64748b; margin-top:6px;">
                Need help with baggage? Contact support or visit the check-in desk at Entebbe.
            </p>
            <div style="margin-top:14px;">
                <img
                    src="https://images.pexels.com/photos/906494/pexels-photo-906494.jpeg?auto=compress&cs=tinysrgb&w=1000"
                    alt="Airline ground handling and baggage"
                    style="width:100%; border-radius:18px; border:1px solid rgba(191, 219, 254, 0.9); display:block;"
                >
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/partials/footer.php'; ?>

