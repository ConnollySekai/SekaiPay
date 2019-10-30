import {hideNotification, toggleSearchBar,toggleConverter, createQRCode} from './../common';

export default {
    
    mounted() {

        const btcAddress = this.$refs.btcAddress.value;

        createQRCode(btcAddress);
   
        toggleConverter();

        toggleSearchBar();

        hideNotification();
    }
}