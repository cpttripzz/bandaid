$(document).ready(function () {
//    alert(window.entity_id );
//    if (localStorage.demoData == undefined) {
//
//        $.getJSON(Routing.generate('musician_show', { id: 1 }), function(data) {
//            localStorage.demoData = JSON.stringify(data);
//        });
//    }

    localStorage.demoData  =  JSON.stringify([{"id":1,"name":"Urna Ut PC"},{"id":2,"name":"Eu Augue LLC"},{"id":3,"name":"Commodo Auctor Consulting"},{"id":4,"name":"Fringilla Purus Mauris Corporation"},{"id":5,"name":"Sodales At Velit Incorporated"},{"id":6,"name":"Arcu Institute"},{"id":7,"name":"Justo Eu Incorporated"},{"id":8,"name":"Elit Limited"},{"id":9,"name":"Sed Orci Associates"},{"id":10,"name":"Ullamcorper Limited"},{"id":11,"name":"Ac Institute"},{"id":12,"name":"Enim Nunc Company"},{"id":13,"name":"Commodo Tincidunt Nibh Company"},{"id":14,"name":"Cursus Luctus Ipsum Associates"},{"id":15,"name":"In Ltd"},{"id":16,"name":"Non Justo Proin Limited"},{"id":17,"name":"Lobortis Company"},{"id":18,"name":"Accumsan Neque Et Inc."},{"id":19,"name":"Ut Pharetra LLC"},{"id":20,"name":"Ac Facilisis Corp."},{"id":21,"name":"Morbi Tristique Foundation"},{"id":22,"name":"Donec Elementum Company"},{"id":23,"name":"In Faucibus Inc."},{"id":24,"name":"Amet Risus Donec LLC"},{"id":25,"name":"Nulla Tincidunt Neque Limited"},{"id":26,"name":"Ipsum Donec Foundation"},{"id":27,"name":"Neque Tellus PC"},{"id":28,"name":"Aliquet Odio Etiam PC"},{"id":29,"name":"Phasellus Fermentum Inc."},{"id":30,"name":"Ac Consulting"},{"id":31,"name":"Malesuada Vel Industries"},{"id":32,"name":"Et Associates"},{"id":33,"name":"Vitae Risus Institute"},{"id":34,"name":"Iaculis Nec Limited"},{"id":35,"name":"Cursus Et Incorporated"},{"id":36,"name":"Sem Molestie Sodales Foundation"},{"id":37,"name":"Consequat Auctor Limited"},{"id":38,"name":"Felis Foundation"},{"id":39,"name":"Nunc Limited"},{"id":40,"name":"Ultrices LLC"},{"id":41,"name":"In Limited"},{"id":42,"name":"Etiam Ltd"},{"id":43,"name":"Mi Pede Industries"},{"id":44,"name":"Tellus Phasellus Corporation"},{"id":45,"name":"Sem Company"},{"id":46,"name":"Diam Duis Mi Corporation"},{"id":47,"name":"Cursus LLC"},{"id":48,"name":"Lacus Corporation"},{"id":49,"name":"Nunc Sed Company"},{"id":50,"name":"Dolor Fusce LLC"},{"id":51,"name":"Natoque Penatibus Et Corp."},{"id":52,"name":"Libero Est Congue Ltd"},{"id":53,"name":"Nisl Arcu Incorporated"},{"id":54,"name":"Sit Amet Orci Incorporated"},{"id":55,"name":"Maecenas Iaculis Aliquet Limited"},{"id":56,"name":"Fermentum Limited"},{"id":57,"name":"Imperdiet Limited"},{"id":58,"name":"Pede Inc."},{"id":59,"name":"Ac Mattis Institute"},{"id":60,"name":"Vitae Incorporated"},{"id":61,"name":"Tempor Augue Ac Institute"},{"id":62,"name":"Eleifend Egestas Sed Limited"},{"id":63,"name":"Nulla Facilisis Suspendisse Incorporated"},{"id":64,"name":"Sed Institute"},{"id":65,"name":"Lacinia At Iaculis LLC"},{"id":66,"name":"In Industries"},{"id":67,"name":"Consectetuer Adipiscing Associates"},{"id":68,"name":"Phasellus Ltd"},{"id":69,"name":"Et Lacinia Vitae Industries"},{"id":70,"name":"Duis Dignissim Tempor PC"},{"id":71,"name":"Commodo Tincidunt Nibh LLC"},{"id":72,"name":"Arcu Industries"},{"id":73,"name":"Id Mollis Nec Associates"},{"id":74,"name":"Quisque Ac Libero PC"},{"id":75,"name":"Adipiscing Non Consulting"},{"id":76,"name":"Nec PC"},{"id":77,"name":"Malesuada Augue Ut LLP"},{"id":78,"name":"Nunc LLC"},{"id":79,"name":"Auctor Quis LLC"},{"id":80,"name":"Tincidunt Tempus Risus Institute"},{"id":81,"name":"Euismod Et Commodo Corp."},{"id":82,"name":"Nunc Quisque Inc."},{"id":83,"name":"Suspendisse Tristique Neque Corporation"},{"id":84,"name":"Mauris Elit Dictum Foundation"},{"id":85,"name":"Vivamus Nisi Mauris Incorporated"},{"id":86,"name":"Placerat Orci Corporation"},{"id":87,"name":"Sodales At Velit Limited"},{"id":88,"name":"Penatibus Et Limited"},{"id":89,"name":"Pretium Neque Incorporated"},{"id":90,"name":"Eget Dictum Placerat Ltd"},{"id":91,"name":"Ante Blandit Corporation"},{"id":92,"name":"Varius Corp."},{"id":93,"name":"Vel Venenatis Vel Institute"},{"id":94,"name":"Etiam Vestibulum Massa Consulting"},{"id":95,"name":"Vulputate Velit Eu Incorporated"},{"id":96,"name":"Commodo LLP"},{"id":97,"name":"Erat Eget Company"},{"id":98,"name":"Justo Nec Company"},{"id":99,"name":"Eget Mollis Associates"},{"id":100,"name":"Dui Ltd"}]);
//    Routing.generate('admin_ze_ba_musician_show', );

    // define filters
    $('#builder').queryBuilder({
        filters: [{
            id: 'date',
            label: 'Datepicker',
            type: 'date',
            validation: {
                format: 'YYYY/MM/DD'
            },
            plugin: 'datepicker',
            plugin_config: {
                format: 'yyyy/mm/dd',
                todayBtn: 'linked',
                todayHighlight: true,
                autoclose: true
            }
        }, {
            id: 'rate',
            label: 'Slider',
            type: 'integer',
            validation: {
                min: 0,
                max: 100
            },
            plugin: 'slider',
            plugin_config: {
                min: 0,
                max: 100,
                value: 0
            },
            onAfterSetValue: function($rule, value) {
                var input = $rule.find('.rule-value-container input');
                input.slider('setValue', value);
                input.val(value); // don't know why I need it
            }
        }, {
            id: 'category',
            label: 'Selectize',
            type: 'string',
            plugin: 'selectize',
            plugin_config: {
                valueField: 'id',
                labelField: 'name',
                searchField: 'name',
                sortField: 'name',
                create: true,
                maxItems: 1,
                plugins: ['remove_button'],
                onInitialize: function() {
                    var that = this,
                        data = JSON.parse(localStorage.demoData);

                    data.forEach(function(item) {
                        that.addOption(item);
                    });

                    that.refreshOptions();
                }
            },
            onAfterCreateRuleInput: function($rule) {
                $rule.find('.rule-value-container').css('min-width', '200px');
            },
            onAfterSetValue: function($rule, value) {
                var selectize = $rule.find('.rule-value-container input')[0].selectize;
                selectize.setValue(value);
            }
        }]
    });

    $('#builder').queryBuilder('setRules', {
        condition: 'OR',
        rules: [{
            id: 'date',
            operator: 'equal',
            value: '1991/11/17'
        }, {
            id: 'rate',
            operator: 'equal',
            value: 22
        }, {
            id: 'category',
            operator: 'equal',
            value: '38'
        }]
    });

});