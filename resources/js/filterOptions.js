export default (function(){

    const rules = {
        btc: [/^(\d+)?([.]?\d{0,8})$/],
    }

    let options = {
        legalKeyCode: [8, 9, 32, 37, 38, 39, 40, 46, 190],
        legalKeyCodeRange: [
                {
                    min: 65,
                    max: 90
                },
                {
                    min: 48,
                    max: 57
                },
                {
                    min: 96,
                    max: 105
                }
            ]
    }
    

    function getOption(rule) {

        const legalReg = rules[rule];

        let newOptions = {...options};

        newOptions.legalReg = legalReg;

        return newOptions;
    }

    return {
        getOption
    }
})();