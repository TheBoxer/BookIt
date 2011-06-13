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