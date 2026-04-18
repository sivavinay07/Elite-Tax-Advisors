<?php include_once 'includes/header.php'; ?>

<div class="container" style="padding: 4rem 0;">
    <div style="text-align: center; max-width: 800px; margin: 0 auto 4rem;">
        <h1 style="font-size: 3rem; color: var(--secondary); margin-bottom: 1rem;">Our Practice Areas</h1>
        <p style="font-size: 1.1rem; color: var(--text-secondary);">We offer tailored solutions designed to protect your wealth, ensure full compliance, and maximize your business's financial efficiency.</p>
    </div>

    <!-- Reusing original classes where possible, or adding inline just for this page so we don't bloat CSS -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
        
        <div class="form-card" style="margin: 0;">
            <div style="font-size: 2.5rem; color: var(--primary); margin-bottom: 1rem;"><i class="fas fa-file-invoice-dollar"></i></div>
            <h3 style="font-size: 1.5rem; color: var(--secondary); margin-bottom: 1rem;">Tax Filing & Return</h3>
            <p style="color: var(--text-secondary);">Accurate and timely tax filing for individuals and corporations. We navigate the latest tax laws to ensure full compliance while maximizing your legal deductions and credits.</p>
        </div>

        <div class="form-card" style="margin: 0;">
            <div style="font-size: 2.5rem; color: var(--primary); margin-bottom: 1rem;"><i class="fas fa-search-dollar"></i></div>
            <h3 style="font-size: 1.5rem; color: var(--secondary); margin-bottom: 1rem;">Audit & Assurance</h3>
            <p style="color: var(--text-secondary);">Independent and objective evaluations of your financial statements. Our auditing services foster transparency and build trust with your stakeholders and investors.</p>
        </div>

        <div class="form-card" style="margin: 0;">
            <div style="font-size: 2.5rem; color: var(--primary); margin-bottom: 1rem;"><i class="fas fa-calculator"></i></div>
            <h3 style="font-size: 1.5rem; color: var(--secondary); margin-bottom: 1rem;">Accounting & Bookkeeping</h3>
            <p style="color: var(--text-secondary);">Meticulous record keeping leaving no stone unturned. Focus firmly on growing your business while we handle your ledgers, payroll, and monthly reports.</p>
        </div>

        <div class="form-card" style="margin: 0;">
            <div style="font-size: 2.5rem; color: var(--primary); margin-bottom: 1rem;"><i class="fas fa-chart-line"></i></div>
            <h3 style="font-size: 1.5rem; color: var(--secondary); margin-bottom: 1rem;">Financial Advisory</h3>
            <p style="color: var(--text-secondary);">Strategic wealth management and corporate financial planning. We help you map out investments, mergers, forecasting, and sustainable pathways to growth.</p>
        </div>

    </div>
</div>

<?php include_once 'includes/footer.php'; ?>
