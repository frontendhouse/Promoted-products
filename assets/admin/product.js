let promotion_checkbox = document.getElementById('_pp_promoted');
if ( promotion_checkbox ) {
    promotion_checkbox.onchange = () => {
        document.querySelector('._pp_custom_title_field').classList.toggle('hidden');
        document.querySelector('._pp_expiration_field').classList.toggle('hidden');
    }
    document.getElementById('_pp_expiration').onchange = () => {
        document.querySelector('._pp_expiration_date_field').classList.toggle('hidden');
    }
}