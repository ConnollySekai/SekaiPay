import Converter from './../components/Converter';

import {hideNotification, toggleSearchBar,toggleConverter} from './../common';

export default {
    components: {
        Converter,
    },
    mounted() {
   
        toggleConverter(this.trans('translations.show_converter'), this.trans('translations.hide_converter'));

        toggleSearchBar();

        hideNotification();
    }
}