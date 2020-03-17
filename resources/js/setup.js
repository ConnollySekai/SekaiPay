import InvoiceForm from './scripts/invoiceForm';

import InvoiceView from './scripts/invoiceView';

import Advertisment from './scripts/advertisement';

function setScript() {

    const scripts = {
        'invoice_form': InvoiceForm,
        'invoice_view': InvoiceView,
        'advertisement': Advertisment
    }

    const page = document.getElementById('page').value;

    if (typeof page === 'undefined') {
        return {};
    }

    return scripts[page];
}

export default setScript();

