<?php include_once 'includes/header.php'; ?>

<div class="container" style="padding: 4rem 0;">
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: start;">
        
        <!-- Contact Info -->
        <div>
            <h1 style="font-size: 3rem; color: var(--secondary); margin-bottom: 1rem;">Get in Touch</h1>
            <p style="font-size: 1.1rem; color: var(--text-secondary); margin-bottom: 2rem;">Ready to level up your financials? Reach out to our advisors, and we will get back to you within 24 business hours.</p>
            
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <div style="display: flex; gap: 1rem; align-items: center;">
                    <div style="width: 50px; height: 50px; background: #e0e7ff; color: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.25rem;">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <h4 style="color: var(--secondary);">Office Location</h4>
                        <p style="color: var(--text-secondary);">123 Financial District, New York, NY 10004</p>
                    </div>
                </div>
                
                <div style="display: flex; gap: 1rem; align-items: center;">
                    <div style="width: 50px; height: 50px; background: #e0e7ff; color: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.25rem;">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <div>
                        <h4 style="color: var(--secondary);">Phone Number</h4>
                        <p style="color: var(--text-secondary);">+1 (555) 123-4567</p>
                    </div>
                </div>
                
                <div style="display: flex; gap: 1rem; align-items: center;">
                    <div style="width: 50px; height: 50px; background: #e0e7ff; color: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.25rem;">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div>
                        <h4 style="color: var(--secondary);">Email Address</h4>
                        <p style="color: var(--text-secondary);">contact@elitetaxadvisors.com</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- The Form -->
        <div class="form-card" style="margin: 0;">
            <div class="form-header">
                <h3>Send an Inquiry</h3>
            </div>

            <?php if(isset($_SESSION['success'])): ?>
                <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
            <?php endif; ?>

            <?php if(isset($_SESSION['error'])): ?>
                <div class="alert alert-error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>

            <form action="process_inquiry.php" method="POST">
                <div class="form-group">
                    <label for="full_name">Full Name *</label>
                    <input type="text" id="full_name" name="full_name" class="form-control" required placeholder="John Doe">
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label for="email">Email Address *</label>
                        <input type="email" id="email" name="email" class="form-control" required placeholder="john@example.com">
                    </div>
                    <div class="form-group">
                        <label for="mobile">Mobile Number *</label>
                        <input type="tel" id="mobile" name="mobile" class="form-control" required placeholder="+1 234 567 8900">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" id="city" name="city" class="form-control" placeholder="New York">
                    </div>
                    <div class="form-group">
                        <label for="service">Interested Service *</label>
                        <select id="service" name="service" class="form-control" required>
                            <option value="" disabled selected>Select...</option>
                            <option value="Tax Filing">Tax Filing</option>
                            <option value="Audit & Assurance">Audit</option>
                            <option value="Accounting">Accounting</option>
                            <option value="Financial Advisory">Advisory</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="message">Your Message *</label>
                    <textarea id="message" name="message" class="form-control" required placeholder="Tell us how we can help you..."></textarea>
                </div>

                <button type="submit" class="btn-primary" style="width: 100%; padding: 0.8rem; font-size:1.05rem;">Submit Inquiry</button>
            </form>
        </div>

    </div>
</div>

<?php include_once 'includes/footer.php'; ?>
