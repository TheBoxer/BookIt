Ext.onReady(function() {
    MODx.load({ xtype: 'bookit-page-home'});
});
 
Bookit.page.Home = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'bookit-panel-home'
            ,renderTo: 'bookit-panel-home-div'
        }]
    });
    Bookit.page.Home.superclass.constructor.call(this,config);
};
Ext.extend(Bookit.page.Home,MODx.Component);
Ext.reg('bookit-page-home',Bookit.page.Home);