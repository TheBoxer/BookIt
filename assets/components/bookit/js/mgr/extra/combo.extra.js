Bookit.combo.Day = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'bookit-extra-combo-day'
        ,name: 'openDay'
        ,hiddenName: 'openDay'
        ,store: new Ext.data.SimpleStore({
            fields: ['number','dayName']
            ,data: [[0,_('bookit.monday')]
                    ,[1,_('bookit.tuesday')]
                    ,[2,_('bookit.wednesday')]
                    ,[3,_('bookit.thursday')]
                    ,[4,_('bookit.friday')]
                    ,[5,_('bookit.saturday')]
                    ,[6,_('bookit.sunday')]]
        })
        ,displayField: 'dayName'
        ,valueField: 'number'
        ,mode: 'local'
        ,triggerAction: 'all'
        ,editable: false
        ,selectOnFocus: true
        ,forceSelection: true
        ,enableKeyEvents: true
    });
    Bookit.combo.Day.superclass.constructor.call(this,config);
};
Ext.extend(Bookit.combo.Day,MODx.combo.ComboBox);
Ext.reg('bookit-extra-combo-day',Bookit.combo.Day);

Bookit.combo.OpenSchedule = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'bookit-extra-combo-openschedule'
        ,name: 'openschedule'
        ,hiddenName: 'openschedule'
        ,url: Bookit.config.connectorUrl
    	,baseParams: { action: 'mgr/bookit/extra/getOpenSchedule' }
    	,fields: ['id','name']
        ,displayField: 'name'
        ,valueField: 'id'
        ,triggerAction: 'all'
        ,editable: false
        ,selectOnFocus: true
        ,forceSelection: true
        ,enableKeyEvents: true
    });
    Bookit.combo.OpenSchedule.superclass.constructor.call(this,config);
};
Ext.extend(Bookit.combo.OpenSchedule,MODx.combo.ComboBox);
Ext.reg('bookit-extra-combo-openschedule',Bookit.combo.OpenSchedule);

Bookit.combo.Pricing = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'bookit-extra-combo-pricing'
        ,name: 'pricing'
        ,hiddenName: 'pricing'
        ,url: Bookit.config.connectorUrl
    	,baseParams: { action: 'mgr/bookit/extra/getPricing' }
    	,fields: ['id','name']
        ,displayField: 'name'
        ,valueField: 'id'
        ,triggerAction: 'all'
        ,editable: false
        ,selectOnFocus: true
        ,forceSelection: true
        ,enableKeyEvents: true
    });
    Bookit.combo.Pricing.superclass.constructor.call(this,config);
};
Ext.extend(Bookit.combo.Pricing,MODx.combo.ComboBox);
Ext.reg('bookit-extra-combo-pricing',Bookit.combo.Pricing);

Bookit.combo.Items = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'bookit-extra-combo-items'
        ,name: 'items'
        ,hiddenName: 'items'
        ,url: Bookit.config.connectorUrl
    	,baseParams: { action: 'mgr/bookit/extra/getItems' }
    	,fields: ['id','name']
        ,displayField: 'name'
        ,valueField: 'id'
        ,triggerAction: 'all'
        ,editable: false
        ,selectOnFocus: true
        ,forceSelection: true
        ,enableKeyEvents: true
    });
    Bookit.combo.OpenSchedule.superclass.constructor.call(this,config);
};
Ext.extend(Bookit.combo.Items,MODx.combo.ComboBox);
Ext.reg('bookit-extra-combo-items',Bookit.combo.Items);

Bookit.combo.UserList = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'bookit-extra-userlist-live',
        name: 'user',
        hiddenName: 'user',
        url: Bookit.config.connectorUrl,
    	baseParams: { action: 'mgr/bookit/extra/getUsers' },
		minChars: 1,
		fields: ['id','fullname'],
		displayField:'fullname',
		valueField: 'id',
		forceSelection: false,
        typeAhead: true,
        selectOnFocus:true,
        loadingText: _('bookit.searching'),
        mode: 'remote',
        editable: true,
        triggerAction: 'all',
        emptyText: _('bookit.fillName')
    });
    Bookit.combo.UserList.superclass.constructor.call(this,config);
};
Ext.extend(Bookit.combo.UserList,MODx.combo.ComboBox);
Ext.reg('bookit-extra-userlist-live',Bookit.combo.UserList);

Bookit.combo.Employee = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'bookit-extra-employees-live',
        name: 'user',
        hiddenName: 'user',
        url: Bookit.config.connectorUrl,
        baseParams: { action: 'mgr/bookit/extra/getEmployees' },
        minChars: 1,
        fields: ['id','fullname'],
        displayField:'fullname',
        valueField: 'id',
        forceSelection: false,
        typeAhead: true,
        selectOnFocus:true,
        loadingText: _('bookit.searching'),
        mode: 'remote',
        editable: true,
        triggerAction: 'all',
        emptyText: _('bookit.fillName')
    });
    Bookit.combo.Employee.superclass.constructor.call(this,config);
};
Ext.extend(Bookit.combo.Employee,MODx.combo.ComboBox);
Ext.reg('bookit-extra-employees-live',Bookit.combo.Employee);

Bookit.combo.LogType = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'bookit-extra-combo-log-type'
        ,name: 'logType'
        ,hiddenName: 'logType'
        ,store: new Ext.data.SimpleStore({
            fields: ['type','typeName']
            ,data: [['log_new_permanent_pass',_('bookit.log_new_permanent_pass')]
                ,['log_new_book',_('bookit.log_new_book')]
                ,['log_pay_debt',_('bookit.log_pay_debt')]
                ,['log_add_credit',_('bookit.log_add_credit')]
                ,['log_add_debt',_('bookit.log_add_debt')]
                ,['log_cancel_book',_('bookit.log_cancel_book')]
                ,['log_pay',_('bookit.log_pay')]
                ,['log_pay_by_credit',_('bookit.log_pay_by_credit')]
                ,['log_client_didnt_come',_('bookit.log_client_didnt_come')]]
        })
        ,displayField: 'typeName'
        ,valueField: 'type'
        ,mode: 'local'
        ,triggerAction: 'all'
        ,editable: false
        ,selectOnFocus: true
        ,forceSelection: true
        ,enableKeyEvents: true
    });
    Bookit.combo.LogType.superclass.constructor.call(this,config);
};
Ext.extend(Bookit.combo.LogType,MODx.combo.ComboBox);
Ext.reg('bookit-extra-combo-log-type',Bookit.combo.LogType);
	