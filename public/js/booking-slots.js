(function (window) {
    var DBT = window.DBT || {};

    DBT.selectedServiceName = function () {
        var ids = ['selectedService', 'service'];
        for (var i = 0; i < ids.length; i++) {
            var el = document.getElementById(ids[i]);
            if (el && el.value) {
                return String(el.value).trim();
            }
        }

        var kidsForm = document.getElementById('kidsBookingForm');
        if (kidsForm) {
            var svc = kidsForm.querySelector('input[name="service"], select[name="service"]');
            if (svc && svc.value) {
                return String(svc.value).trim();
            }
        }

        return '';
    };

    DBT.slotsUrl = function (dateYmd, serviceName) {
        var url = '/bookings/slots?date=' + encodeURIComponent(dateYmd);
        serviceName = serviceName || DBT.selectedServiceName();
        if (serviceName) {
            url += '&service=' + encodeURIComponent(serviceName);
        }
        return url;
    };

    DBT.fetchSlots = function (dateYmd, serviceName) {
        return fetch(DBT.slotsUrl(dateYmd, serviceName)).then(function (response) {
            return response.json();
        });
    };

    window.DBT = DBT;
})(window);
