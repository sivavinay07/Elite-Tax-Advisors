<?php include_once 'includes/header.php'; ?>

<div class="section fade-in">
    <div class="container">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 5rem; align-items: start;">
            
            <!-- Contact Info -->
            <div class="fade-in" style="animation-delay: 0.2s;">
                <div class="feature-badge" style="margin-bottom: 1.5rem; background: hsla(243, 75%, 59%, 0.1); color: var(--primary);">
                    <i class="fas fa-headset"></i> Support Center
                </div>
                <h1 style="font-size: 3.5rem; margin-bottom: 1.5rem;">Let's Start a Conversation</h1>
                <p style="font-size: 1.25rem; color: var(--text-muted); margin-bottom: 3rem;">Partner with us to transform your financial strategy and secure your business's future.</p>
                
                <div style="display: grid; gap: 2rem;">
                    <div style="display: flex; gap: 1.5rem; align-items: center;">
                        <div class="card-icon" style="margin-bottom: 0; min-width: 60px; height: 60px;"><i class="fas fa-location-dot"></i></div>
                        <div>
                            <h4 style="font-size: 1.1rem;">HQ Location</h4>
                            <p style="color: var(--text-muted);">123 Wall Street, Suite 500, New York, NY</p>
                        </div>
                    </div>
                    
                    <div style="display: flex; gap: 1.5rem; align-items: center;">
                        <div class="card-icon" style="margin-bottom: 0; min-width: 60px; height: 60px;"><i class="fas fa-phone-volume"></i></div>
                        <div>
                            <h4 style="font-size: 1.1rem;">Direct Line</h4>
                            <p style="color: var(--text-muted);">+1 (800) 123-ELITE</p>
                        </div>
                    </div>
                    
                    <div style="display: flex; gap: 1.5rem; align-items: center;">
                        <div class="card-icon" style="margin-bottom: 0; min-width: 60px; height: 60px;"><i class="fas fa-envelope-open-text"></i></div>
                        <div>
                            <h4 style="font-size: 1.1rem;">Official Email</h4>
                            <p style="color: var(--text-muted);">hello@elitetax.com</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- The Form (Glassmorphism inspired) -->
            <div class="form-card fade-in" style="animation-delay: 0.4s;">
                <div style="margin-bottom: 2.5rem;">
                    <h3 style="font-size: 1.75rem; margin-bottom: 0.5rem;">Send an Inquiry</h3>
                    <p style="color: var(--text-muted);">Fill out the form below and an expert will reach out within 24 hours.</p>
                </div>

                <?php if(isset($_SESSION['success'])): ?>
                    <div class="alert alert-success fade-in"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
                <?php endif; ?>

                <?php if(isset($_SESSION['error'])): ?>
                    <div class="alert alert-error fade-in"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
                <?php endif; ?>

                <form action="process_inquiry.php" method="POST">
                    <div class="form-group">
                        <label for="full_name">Full Name *</label>
                        <input type="text" id="full_name" name="full_name" class="form-control" required placeholder="Johnathan Doe">
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                        <div class="form-group">
                            <label for="email">Work Email *</label>
                            <input type="email" id="email" name="email" class="form-control" required placeholder="john@company.com">
                        </div>
                        <div class="form-group">
                            <label for="mobile">Mobile Number *</label>
                            <input type="tel" id="mobile" name="mobile" class="form-control" required placeholder="+1 234 567 8900">
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                        <div class="form-group">
                            <label for="city">Current City</label>
                            <input type="text" id="city" name="city" class="form-control" placeholder="Silicon Valley">
                        </div>
                        <div class="form-group">
                            <label for="service">Required Expertise *</label>
                            <select id="service" name="service" class="form-control" required>
                                <option value="" disabled selected>Select Domain</option>
                                <option value="Tax Filing">Tax Optimization</option>
                                <option value="Audit & Assurance">Global Audit</option>
                                <option value="Accounting">Corporate Ledgers</option>
                                <option value="Financial Advisory">Strategic Advisory</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="message">Your Objectives *</label>
                        <textarea id="message" name="message" class="form-control" required placeholder="Tell us about your financial goals..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 1.25rem;">Ship Inquiry <i class="fas fa-paper-plane"></i></button>
                </form>
            </div>

        </div>
    </div>
</div>

<?php include_once 'includes/footer.php'; ?>
