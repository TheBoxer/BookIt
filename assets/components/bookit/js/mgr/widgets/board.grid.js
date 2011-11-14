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
        ,fields: boarderFields
        ,autosave: true
        ,paging: true
        ,remoteSort: true
        ,enableDragDrop: false
        ,enableColumnMove: false
        ,anchor: '97%'
        ,autoExpandColumn: 'name'
    	,listeners: {
    		'cellcontextmenu': {fn:this.test}
        }
		,tbar:[{
			xtype: 'datefield'
			,format: MODx.config.manager_date_format 
			,emptyText: _('bookit.today')
			,listeners: {
                'select': {fn:this.filterDay,scope:this}
            }
		},'-','-','-','-',{
			xtype: 'timefield'
			,emptyText: _('bookit.hour')
			,format: MODx.config.manager_time_format 
			,increment: 60
			,minValue: '07:00'
			,maxValue: '21:00'
		}]
		,itemOpen: function() {
			location.href = 'index.php?a='+MODx.action['controllers/index']+'&action=openSchedule'+'&id='+this.menu.record.id;
		}
        ,columns: columns
    });
    Bookit.grid.Board.superclass.constructor.call(this,config);
    
	
};
Ext.extend(Bookit.grid.Board,MODx.grid.Grid, {
	filterDay: function(cb,nv,ov) {
        this.getStore().setBaseParam('filterDay',cb.getValue());
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
    ,test: function(grid, rowIndex, cellIndex, e) {
    	var row = grid.store.data.items[rowIndex];
		var colName = grid.colModel.config[cellIndex].dataIndex;
		var val = row.data[colName];
		
		//alert(row.data.time);
    	 
    	if(cellIndex > 0){
    		cellIndex -= 1;
	    	if(val == ""){
	    		menu = new Ext.menu.Menu({
		    		items:[{
		    			text: 'New reservation'
		    			,handler: function(){
		    				alert(cellIndex);
		    			}
		    		}]
		    	});
	    	}else{
	    		menu = new Ext.menu.Menu({
		    		items:[{
		    			text: 'View details'
		    			,handler: function(){
		    				MODx.Ajax.request({
		    		            url: Bookit.config.connectorUrl
		    		            ,params: {
		    		                action: 'mgr/bookit/test'
		    		            }
		    			        ,listeners: {
		    			            'success': {fn:function(r) {
		    			            	if (!this.detailsWindow) {
		    		    			        this.detailsWindow = MODx.load({
		    		    			            xtype: 'bookit-window-details'
		    		    			            ,record: r.object
		    		    			            ,listeners: {
		    		    			                'success': {fn:this.refresh,scope:this}
		    		    			            }
		    		    			        });
		    		    			    } else {
		    		    			        this.detailsWindow.setValues(r.object);
		    		    			    }
		    		    			    this.detailsWindow.show(e.target);
		    			            },scope:this}
		    			        }
		    		        });
		    				
		    			}
		    		}]
		    	});
	    	}
	    	menu.showAt(e.getXY());
    	}
    }
});
Ext.reg('bookit-grid-board',Bookit.grid.Board);

Bookit.window.Details = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'bookit-window-details'
        ,title: _('bookit.addPrice')
        ,url: Bookit.config.connectorUrl
        /*,baseParams: {
            action: 'mgr/bookit/pricing/items/addPricingItem'
            ,pricing_list: MODx.request.id
        }*/
        ,fields: [{
            focus: true
            ,xtype: 'statictextfield'
            ,fieldLabel: 'surname'
            ,name: 'surname'
            ,id: 'surname'
            ,width: 300
        },{
            focus: true
            ,xtype: 'statictextfield'
            ,fieldLabel: 'firstname'
            ,name: 'firstname'
            ,width: 300
        }]
        ,buttons: [{
            text: config.cancelBtnText || _('cancel')
            ,scope: this
            ,handler: function() { this.close(); }
        }]
    });
    Bookit.window.Details.superclass.constructor.call(this,config);
    this.on('beforeshow',function() {
    	//this.findById('surname').value = "test";
    	/*MODx.Ajax.request({
            url: this.config.url
            ,params: {
                action: 'mgr/bookit/test'
            }
	        ,listeners: {
	            'success': {fn:function(r) {
	            	this.findById('surname').value = "test";
	                //alert(r.object.test);
	            },scope:this}
	        }
        });*/
    });
};
Ext.extend(Bookit.window.Details,MODx.Window);
Ext.reg('bookit-window-details',Bookit.window.Details);
