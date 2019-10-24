export default {
    btc: {
        legalReg : [/^(\d+)?([.]?\d{0,8})$/], 
        legalKeyCode: [8, 32, 37, 38, 39, 40, 46, 190],
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
}