import InvoiceForm from './scripts/invoiceForm';

import InvoiceView from './scripts/invoiceView';

function setScript() {

    const scripts = {
        'invoice_form': InvoiceForm,
        'invoice_view': InvoiceView
    }

    const page = document.getElementById('page').value;

    if (typeof page === 'undefined') {
        return {};
    }

    return scripts[page];
}

export default setScript();

