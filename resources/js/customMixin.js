export default {
    methods: {
        replaceNumber: function (n) {
            if (n != undefined) {
                n = n.toString();
                const find = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
                const replace = ["۰", "۱", "۲", "۳", "۴", "۵", "۶", "۷", "۸", "۹"];
                for (let i = 0; i < find.length; i++) {
                    n = n.replace(new RegExp(find[i], 'g'), replace[i]);
                }
                return n;
            }
        },
        check_mobile_number() {
            if (isNaN(this.mobile)) {
                return true;
            }
            else {
                if (this.mobile.toString().trim().length == 11) {
                    if (this.mobile.toString().charAt(0) == '0' && this.mobile.toString().charAt(1) == '9') {
                        return false;
                    }
                    else {
                        return true;
                    }
                }
                else if (mthis.obile.toString().trim().length == 10) {
                    if (this.mobile.toString().charAt(0) == '9') {
                        return false;
                    }
                    else {
                        return true;
                    }
                }
                else {
                    return true;
                }
            }
        },
        number_format: function (num) {
            num = num.toString();
            let format = '';
            let counter = 0;
            for (let i = num.length - 1; i >= 0; i--) {
                format += num[i];
                counter++;
                if (counter == 3) {
                    format += ",";
                    counter = 0;
                }
            }
            return format.split('').reverse().join('');
        },
        gregorian_to_jalali: function (gy, gm, gd) {
            var g_d_m, jy, jm, jd, gy2, days;
            g_d_m = [0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334];
            if (gy > 1600) {
                jy = 979;
                gy -= 1600;
            } else {
                jy = 0;
                gy -= 621;
            }
            gy2 = (gm > 2) ? (gy + 1) : gy;
            days = (365 * gy) + (parseInt((gy2 + 3) / 4)) - (parseInt((gy2 + 99) / 100)) + (parseInt((gy2 + 399) / 400)) - 80 + gd + g_d_m[gm - 1];
            jy += 33 * (parseInt(days / 12053));
            days %= 12053;
            jy += 4 * (parseInt(days / 1461));
            days %= 1461;
            if (days > 365) {
                jy += parseInt((days - 1) / 365);
                days = (days - 1) % 365;
            }
            jm = (days < 186) ? 1 + parseInt(days / 31) : 7 + parseInt((days - 186) / 30);
            jd = 1 + ((days < 186) ? (days % 31) : ((days - 186) % 30));
            return [jy, jm, jd];
        },
    }
};