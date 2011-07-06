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