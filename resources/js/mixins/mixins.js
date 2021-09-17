export default {
    methods: {
        dateDiff(date1) {
            var d1 = new Date(date1);
            var d2 = new Date();

            var diff = d1.getTime() - d2.getTime();

            var days = Math.ceil(diff / (1000 * 60 * 60 * 24));

            return days
        },
        dateFormat(date){
            let d = new Date(date)
            return `${d.getFullYear()}/${d.getMonth()}/${d.getDate()}`
        }
    }
}
