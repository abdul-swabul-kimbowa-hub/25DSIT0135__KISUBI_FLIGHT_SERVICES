<?php
$page_title = 'Kisubi Airlines | Fly Uganda and Beyond';
require_once __DIR__ . '/partials/header.php';
?>

<main>
    <section class="hero">
        <div>
            <h1 class="hero-title">
                Discover Uganda from the
                <span class="hero-highlight">Skies of Kisubi</span>
            </h1>
            <p class="hero-subtitle">
                Book seamless flights from Entebbe to your favourite African and global destinations.
                Enjoy a modern cabin experience, reliable schedules, and warm Ugandan hospitality.
            </p>
            <div class="hero-tags">
                <span class="tag-pill">Entebbe Hub</span>
                <span class="tag-pill">Non-stop African Routes</span>
                <span class="tag-pill">Flexible Fares</span>
            </div>

            <div style="margin-top: 26px; max-width: 620px;">
                <form class="glass-panel search-card" action="search_results.php" method="get">
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <span style="font-size:0.82rem; text-transform:uppercase; letter-spacing:0.1em; color:#9ca3af;">
                            Flight search
                        </span>
                        <div style="display:flex; gap:8px; font-size:0.8rem; color:#9ca3af;">
                            <label>
                                <input type="radio" name="trip_type" value="oneway" checked> One-way
                            </label>
                            <label>
                                <input type="radio" name="trip_type" value="round"> Round-trip
                            </label>
                        </div>
                    </div>

                    <div class="search-grid">
                        <div>
                            <label class="form-label" for="origin">From</label>
                            <input class="form-input" type="text" id="origin" name="origin" placeholder="Entebbe (EBB)" required>
                        </div>
                        <div>
                            <label class="form-label" for="destination">To</label>
                            <input class="form-input" type="text" id="destination" name="destination" placeholder="Nairobi (NBO)" required>
                        </div>
                        <div>
                            <label class="form-label" for="departure_date">Departure</label>
                            <input class="form-input" type="date" id="departure_date" name="departure_date" required>
                        </div>
                        <div>
                            <label class="form-label" for="return_date">Return</label>
                            <input class="form-input" type="date" id="return_date" name="return_date">
                        </div>
                        <div>
                            <label class="form-label" for="cabin">Cabin</label>
                            <select class="form-select" id="cabin" name="cabin">
                                <option value="Economy">Economy</option>
                                <option value="Business">Business</option>
                                <option value="First">First</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label" for="passengers">Passengers</label>
                            <input class="form-input" type="number" id="passengers" name="passengers" min="1" value="1" required>
                        </div>
                    </div>

                    <div class="search-actions">
                        <button type="submit" class="btn-primary">Search flights</button>
                        <a class="btn-secondary" href="my_bookings.php">Manage booking</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="hero-side">
            <div class="hero-slideshow">
                <div class="hero-slide hero-slide-active">
                    <img src="assets/images/hero1.jpg"
                         alt="Aircraft over Entebbe sunset">
                </div>
                <div class="hero-slide">
                    <img src="assets/images/hero2.jpg"
                         alt="Cabin interior with blue lighting">
                </div>
                <div class="hero-slide">
                    <img src="assets/images/hero3.jpg"
                         alt="Wing over clouds in blue sky">
                </div>
            </div>
            <div class="hero-stat-card">
                <div style="font-size:0.7rem; text-transform:uppercase; letter-spacing:0.1em; color:#9ca3af;">
                    Today from Entebbe
                </div>
                <div class="hero-stat-value">24 flights</div>
                <div style="font-size:0.75rem; color:#9ca3af;">Average on-time performance: 92%</div>
            </div>
        </div>
    </section>

    <section class="section">
        <h2 class="section-title">Popular routes from Entebbe</h2>
        <div class="destinations-grid">
            <article class="destination-card">
                <img src="https://images.pexels.com/photos/460672/pexels-photo-460672.jpeg?auto=compress&cs=tinysrgb&w=800"
                     alt="Nairobi skyline">
                <div class="destination-overlay">Entebbe &rarr; Nairobi</div>
            </article>
            <article class="destination-card">
                <img src="https://images.pexels.com/photos/325193/pexels-photo-325193.jpeg?auto=compress&cs=tinysrgb&w=800"
                     alt="Johannesburg city">
                <div class="destination-overlay">Entebbe &rarr; Johannesburg</div>
            </article>
            <article class="destination-card">
                <img src="https://images.pexels.com/photos/3787839/pexels-photo-3787839.jpeg?auto=compress&cs=tinysrgb&w=800"
                     alt="Dubai skyline at night">
                <div class="destination-overlay">Entebbe &rarr; Dubai</div>
            </article>
            <article class="destination-card">
                <img src="https://images.pexels.com/photos/672532/pexels-photo-672532.jpeg?auto=compress&cs=tinysrgb&w=800"
                     alt="London city">
                <div class="destination-overlay">Entebbe &rarr; London</div>
            </article>
        </div>
    </section>

    <section class="section">
        <h2 class="section-title">Cabin crew & onboard service</h2>
        <div style="display:grid; grid-template-columns:minmax(0,1fr) minmax(0,1fr); gap:18px; align-items:center;">
            <div class="glass-panel" style="padding:18px;">
                <h3 style="margin-top:0; margin-bottom:8px; font-size:1.05rem;">Warm, professional hospitality</h3>
                <p style="margin-top:0; color:#64748b;">
                    Enjoy attentive cabin service inspired by Ugandan hospitality—comfort-first seating, friendly assistance,
                    and a calm, premium feel across every cabin.
                </p>
                <div style="display:flex; gap:10px; flex-wrap:wrap; margin-top:12px;">
                    <span class="tag-pill">Friendly crew</span>
                    <span class="tag-pill">Comfort-first</span>
                    <span class="tag-pill">On-time focus</span>
                </div>
            </div>
            <div class="glass-panel" style="padding:10px;">
                <div class="mini-slideshow" data-slideshow="crew">
                    <div class="mini-slide mini-slide-active">
                        <img src="assets/images/crew1.jpg"
                             alt="Cabin crew in uniform">
                    </div>
                    <div class="mini-slide">
                        <img src="assets/images/crew2.jpg"
                             alt="Airline crew welcoming passengers">
                    </div>
                    <div class="mini-slide">
                        <img src="assets/images/crew3.jpg"
                             alt="Flight attendant service onboard">
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
    // Simple hero slideshow
    (function () {
        const slides = document.querySelectorAll('.hero-slide');
        if (!slides.length) return;
        let index = 0;
        setInterval(() => {
            slides[index].classList.remove('hero-slide-active');
            index = (index + 1) % slides.length;
            slides[index].classList.add('hero-slide-active');
        }, 5000);
    })();

    // Small slideshows (e.g., cabin crew)
    (function () {
        const containers = document.querySelectorAll('[data-slideshow="crew"]');
        containers.forEach((container) => {
            const slides = container.querySelectorAll('.mini-slide');
            if (!slides.length) return;
            let index = 0;
            setInterval(() => {
                slides[index].classList.remove('mini-slide-active');
                index = (index + 1) % slides.length;
                slides[index].classList.add('mini-slide-active');
            }, 4500);
        });
    })();
</script>

<?php require_once __DIR__ . '/partials/footer.php'; ?>

