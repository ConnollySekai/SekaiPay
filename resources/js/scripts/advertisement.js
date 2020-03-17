import {hideNotification, toggleSearchBar} from './../common';

export default {
    mounted() {
   
        toggleSearchBar();

        hideNotification();
    }
}