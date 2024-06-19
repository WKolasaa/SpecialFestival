document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('exportBtn').addEventListener('click', function () {
        var exportType = document.getElementById('exportType').value;

        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/api/orders/exportOrders', true);
        xhr.responseType = 'blob';
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function (e) {
            if (this.status == 200) {
                var blob = new Blob([this.response], {type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'});
                var downloadUrl = URL.createObjectURL(blob);
                var a = document.createElement("a");
                a.href = downloadUrl;
                a.download = "orders." + exportType;
                document.body.appendChild(a);
                a.click();
            } else {
                console.error('Export failed:', this.status, this.statusText);
            }
        };
        xhr.send('exportType=' + exportType);
    });
});