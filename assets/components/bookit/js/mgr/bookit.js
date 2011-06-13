var Bookit = function(config) {
    config = config || {};
    Bookit.superclass.constructor.call(this,config);
};
Ext.extend(Bookit,Ext.Component,{
    page:{},window:{},grid:{},tree:{},panel:{},combo:{},config: {}
});
Ext.reg('bookit',Bookit);
Bookit = new Bookit();