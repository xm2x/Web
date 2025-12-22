document.addEventListener('DOMContentLoaded', () => {
    // Plan card selection
    document.querySelectorAll('.plan-card').forEach(card => {
        card.addEventListener('click', e => {
            if (!e.target.classList.contains('select-btn')) {
                document.querySelectorAll('.plan-card').forEach(c => c.classList.remove('active'));
                card.classList.add('active');
            }
        });
    });

    // Select button alerts
    document.querySelectorAll('.select-btn').forEach(btn => {
        btn.addEventListener('click', e => {
            e.stopPropagation();
            const plan = btn.closest('.plan-card').querySelector('h2').textContent;
            alert(`You selected the ${plan}! Redirecting to checkout...`);
        });
    });

    // Dropdown toggle
    const info = document.getElementById('info');
    const dropdown = document.getElementById('dropdown-menu');
    
    if (info && dropdown) {
        info.onclick = e => {
            e.stopPropagation();
            dropdown.classList.toggle('show');
        };
        
        document.onclick = () => dropdown.classList.remove('show');
    }
});