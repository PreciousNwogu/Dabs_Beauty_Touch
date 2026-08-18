<script>
window.DBT_I18N = Object.assign({}, @json(__('booking.js')), @json(__('kids.js')));
window.DBT_I18N.locale = @json(str_replace('_', '-', app()->getLocale()));
window.dbtT = function (key, replacements) {
    var s = (window.DBT_I18N && window.DBT_I18N[key]) || key;
    if (replacements) {
        Object.keys(replacements).forEach(function (k) {
            s = String(s).split(':' + k).join(replacements[k]);
        });
    }
    return s;
};
window.DBT_KIDS = {
    finishLabel: function (value) {
        if (value === 'curled') return window.dbtT('finish_curled');
        if (value) return window.dbtT('finish_plain');
        return '';
    },
    lengthLabel: function (value, full) {
        var map = full ? {
            shoulder: window.dbtT('length_shoulder_full'),
            armpit: window.dbtT('length_armpit_full'),
            mid_back: window.dbtT('length_mid_back_full'),
            waist: window.dbtT('length_waist_full')
        } : {
            shoulder: window.dbtT('length_shoulder'),
            armpit: window.dbtT('length_armpit'),
            mid_back: window.dbtT('length_mid_back'),
            waist: window.dbtT('length_waist')
        };
        return map[value] || value || '';
    },
    addonLabel: function (id) {
        var map = {
            kb_add_detangle: window.dbtT('addon_detangle'),
            kb_add_beads: window.dbtT('addon_beads'),
            kb_add_beads_full: window.dbtT('addon_beads_full'),
            kb_add_extension: window.dbtT('addon_extension'),
            kb_add_rest: window.dbtT('addon_rest')
        };
        return map[id] || id;
    }
};
</script>
