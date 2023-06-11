window.getCurrentDate = getCurrentDate = () => {
    const currentDate = new Date();

    const day = String(currentDate.getDate()).padStart(2, '0');
    const month = String(currentDate.getMonth() + 1).padStart(2, '0');
    const year = currentDate.getFullYear();

    return day + '-' + month + '-' + year;
}

window.replaceStringWithObjectValues = function replaceStringWithObjectValues(str, obj) {
    const regex = /\{([^}]+)\}/g;
    const matches = str.match(regex);

    if (matches) {
        matches.forEach(match => {
            const key = match.substring(1, match.length - 1);
            if (obj.hasOwnProperty(key)) {
                str = str.replace(match, obj[key]);
            }
        });
    }

    return str;
}

window.confirmAlert = ({ formId, deleteUrl }) => {
    var form = $(`#${formId}`);
    form.attr('action', deleteUrl);
}
