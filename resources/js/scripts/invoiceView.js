import Converter from './../components/Converter';

import {hideNotification, toggleSearchBar,toggleConverter} from './../common';

export default {
    components: {
        Converter,
    },
    mounted() {
   
        toggleConverter();

        toggleSearchBar();

        hideNotification();
    }
}