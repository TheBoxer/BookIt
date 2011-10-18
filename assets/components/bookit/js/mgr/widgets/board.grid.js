function filterHour(cb,nv,ov) {
	Ext.getCmp('bookit-grid-board').getStore().setBaseParam('test',cb.getValue());
	Ext.getCmp('bookit-grid-board').getBottomToolbar().changePage(1);
	Ext.getCmp('bookit-grid-board').refresh();

}

Bookit.grid.Board = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'bookit-grid-board'
        ,url: Bookit.config.connectorUrl
        ,baseParams: { action: 'mgr/bookit/getReservations' }
        ,fields: ['id','item', 'time', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday']
        ,autosave: true
        ,paging: true
        ,remoteSort: true
        ,enableDragDrop: false
        ,anchor: '97%'
        ,autoExpandColumn: 'name'
		,tbar:[{
			xtype: 'datefield'
			,format: MODx.config.manager_date_format 
			,emptyText: 'Datum'
		},'-','-','-','-',{
            xtype: 'bookit-extra-combo-items'
            ,id: 'bookit-pricing-item-filter-day'
            ,listeners: {
            	'select': {fn:filterHour,scope:this}
            }
        },{
			xtype: 'timefield'
			,format: MODx.config.manager_time_format 
			,increment: 60
			,minValue: '07:00'
			,maxValue: '21:00'
		}]
		,itemOpen: function() {
			location.href = 'index.php?a='+MODx.action['controllers/index']+'&action=openSchedule'+'&id='+this.menu.record.id;
		}
        ,columns: [{
        	header: _('bookit.item')
        	,dataIndex: 'item'
        },{
        	header: _('bookit.time')
        	,dataIndex: 'time'
        },{
            header: _('bookit.monday')
            ,dataIndex: 'monday'
        },{
        	header: _('bookit.tuesday')
        	,dataIndex: 'tuesday'    	
        },{
        	header: _('bookit.wednesday')
        	,dataIndex: 'wednesday'
        },{
        	header: _('bookit.thursday')
        	,dataIndex: 'thursday'
        },{
        	header: _('bookit.friday')
        	,dataIndex: 'friday'
        },{
        	header: _('bookit.saturday')
        	,dataIndex: 'saturday'
        },{
        	header: _('bookit.sunday')
        	,dataIndex: 'sunday'
        }]
    });
    Bookit.grid.Board.superclass.constructor.call(this,config)
};
Ext.extend(Bookit.grid.Board,MODx.grid.Grid, {
	
});
Ext.reg('bookit-grid-board',Bookit.grid.Board);

