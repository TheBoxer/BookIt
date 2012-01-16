Bookit.grid.Users = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'bookit-grid-users'
        ,url: Bookit.config.connectorUrl
        ,baseParams: { action: 'mgr/bookit/users/getRows' }
        ,fields: ['id','fullname', 'credit', 'warnings', 'debt']
        ,autosave: true
        ,paging: true
        ,remoteSort: false
        ,enableDragDrop: false
        ,anchor: '97%'
        ,autoExpandColumn: 'fullname'
    	,tbar:[{
    	    xtype: 'textfield'
    	    ,id: 'bookit-gird-users-search'
    	    ,emptyText: _('bookit.search')
    	    ,listeners: {
    	        'change': {fn:this.search,scope:this}
    	        ,'render': {fn: function(cmp) {
    	            new Ext.KeyMap(cmp.getEl(), {
    	                key: Ext.EventObject.ENTER
    	                ,fn: function() {
    	                    this.fireEvent('change',this);
    	                    this.blur();
    	                    return true;
    	                }
    	                ,scope: cmp
    	            });
    	        },scope:this}
    	    }
    	}]
        ,columns: [{
        	header: _('id')
        	,dataIndex: 'id'
        	,sortable: true
        },{
        	header: _('bookit.fullname')
            ,dataIndex: 'fullname'
            ,sortable: true
        },{
        	header: _('bookit.credit')
            ,dataIndex: 'credit'
            ,sortable: true
        },{
        	header: _('bookit.warnings')
            ,dataIndex: 'warnings'
            ,sortable: true
        },{
        	header: _('bookit.debt')
            ,dataIndex: 'debt'
            ,sortable: true
        }]
    });
    Bookit.grid.Users.superclass.constructor.call(this,config)
};
Ext.extend(Bookit.grid.Users,MODx.grid.Grid, {
    search: function(tf,nv,ov) {
        var s = this.getStore();
        s.baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
});
Ext.reg('bookit-grid-users',Bookit.grid.Users);
