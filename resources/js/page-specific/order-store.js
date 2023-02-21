const dateInput = document.getElementById('order_date');
const phoneInput = document.getElementById('phone');
const dateMaskOptions = {
    // mask: '00.00.0000',
    mask: 'DD.MM.YYYY',
    blocks: {
        DD: {
            mask: window.IMask.MaskedRange,
            from: 1,
            to: 31
        },

        MM: {
            mask:  window.IMask.MaskedRange,
            from: 1,
            to: 12
        },
        YYYY: {
            mask: '0000',
        },
    }
};

let a = window.IMask(dateInput, dateMaskOptions);
let b = window.IMask(phoneInput, {
    mask: '+7 (000) 000 00 00'
});
