/*Cameron Blanchard
 * July 5, 2013*/
 
 /* In this file:
  * class tree
  * class node
  * class TreeControl
  * 
  * TODO:
  * Add the option to change the colour
  * Improve efficiency a lot
  * Add divs as required instead of all at the beginning*/

console.log("Tree library included");

function TreeControl(myTree, divID)
{

    //Need to make these hidden elements, or else the css won't load before it is needed.
    $('head').prepend('<link rel="stylesheet" type="text/css" href="'+$('script[src$="tree.js"]').attr('src').replace('tree.js','')+'tree_styles.css"></link>')
    $("#"+divID).append('<ul class="tree_column" style="display:none"></ul>')
    $("#"+divID).append('<ul class="tree_node" style="display:none"></ul>')
    $("#"+divID).append('<div class="relation_line" style="display:none"></div>')

    this.columns = Array();
    this.childDepths = Array();
    this.myTree = myTree;
    this.divID = divID;
    this.toggleParent = toggleParent;
    this.showNode = showNode;
    this.hideNode = hideNode;
    this.hideChildren = hideChildren;
    this.addNodeToColumn = addNodeToColumn;
    this.updateNodePositions = updateNodePositions;
    this.updateLines = updateLines;
    this.display = display;
    this.showTree = showTree;
    this.async = async;
    this.when = when;
    this.cssLoaded = cssLoaded;
    

    
    function async(fn)
    {
        setTimeout(fn, 20);
    }
    
    function when(cond, fn, params)
    {
        async(function(){
            if (cond())
            {
                fn.call(params);
            }else{
                async(arguments.callee);
            } 
            });
    }
    
    function cssLoaded()
    {
        return $('.relation_line').css("position") == "absolute";
    }
    
    
    function display()
    {
        when(cssLoaded, this.showTree, this);
    }
    
    function showTree()
    {
        //Find the maximum depth of the tree
        /*
        for (var i=0; i<this.myTree.nodes.length;i++) 
        {
            if (this.myTree.nodes[i].children.length == 0)
            {
                this.childDepths.push(this.myTree.depth( '#' + this.myTree.nodes[i].id));
            }
        }*/
        
        for (var node in this.myTree.nodes)
        {
            if (this.myTree.nodes[node].children.length == 0)
            {
                this.childDepths.push(this.myTree.depth(node));
            }
        }
        
        this.maxDepth = Math.max.apply(Math, this.childDepths);

        //Add all of the nodes to the tree display
        /*
        for (var i=0; i< this.myTree.nodes.length;i++) 
        {
            this.addNodeToColumn(this.myTree.nodes[i].id, this.maxDepth);
        }*/

        for (var node in this.myTree.nodes)
        {
            this.addNodeToColumn(this.myTree.nodes[node].id, this.maxDepth);
        }
        
        
        //Position the nodes, position the lines and add new ones as necessary
        this.updateNodePositions();
        //Make sure that the container is not scrolled at all, to avoid all kinds of nasty problems
        $("#"+this.divID).scrollTop(0);

        this.updateLines();
    }
    

    //Toggles a node's parent's visibility
    function toggleParent(id)
    {
        //Do nothing when a root node is clicked
        if (this.myTree.nodes[id].parent == -1)
        {
            return;
        }
        if (this.myTree.nodes[this.myTree.nodes[id].parent].hidden == false)
        {
            this.hideNode(this.myTree.nodes[id].parent);
            childrenOf = this.myTree.nodes[id].parent; //the node whose children we are hiding
            this.hideChildren(childrenOf,id);
        }
        else
        {
            this.showNode(this.myTree.nodes[id].parent);
        }
    }

    //Shows a specified node, and all of its children. Might end up changing
    function showNode(id)
    {
        this.myTree.nodes[id].show();
        $('#tree_'+id).stop();
        $('#tree_'+id).animate({opacity:1},duration=500);
        
        for (var i=0;i<this.myTree.nodes[id].children.length; i++)
        {
            this.showNode(this.myTree.nodes[id].children[i])
        }
        
        $('[id^=line_'+id+'b]').stop();
        $('[id^=line_'+id+'b]').animate({opacity:1},duration=500);
        if (this.myTree.nodes[id].parent != -1)
        {
            $('#line_'+this.myTree.nodes[id].parent+'b'+id).stop();
            $('#line_'+this.myTree.nodes[id].parent+'b'+id).animate({opacity:1},duration=500);
        }
    }

    //Hides a node, and its parent if necessary
    function hideNode(id)
    {
        if (id == -1)
        {
            return
        }
        
        this.myTree.nodes[id].hide();
        var flag = false;
        
        //Hide the node and all of the lines associated with it
        $('[id^=line_'+id+'b]').stop();
        $('#line_'+this.myTree.nodes[id].parent+'b'+id).stop();
        $('#tree_'+id).stop();
        $('[id^=line_'+id+'b]').animate({opacity:0}, duration=500);
        $('#line_'+this.myTree.nodes[id].parent+'b'+id).animate({opacity:0},duration=500);
        $('#tree_'+id).animate({opacity:0}, duration=500);
        
        //If the node being hidden is the last visible child of its parent, its parent should be hidden as well
        pid = this.myTree.nodes[id].parent;
        if (pid !=-1)
        {
            for (var i=0;i<this.myTree.nodes[pid].children.length; i++)
            {
                if (!this.myTree.nodes[this.myTree.nodes[pid].children[i]].hidden)
                {
                    flag = true;
                }
            }
        }
        if (flag == false)
        {
            this.hideNode(pid);
        }
        
    }

    //Hides all the children of a node, except the node specifed by noHide
    function hideChildren(id, noHide)
    {
        for (var x=0; x <this.myTree.nodes[id].children.length;x++)
        {
            if (this.myTree.nodes[id].children[x] != noHide && this.myTree.nodes[this.myTree.nodes[id].children[x]].column != 0)
            {
                this.hideNode(this.myTree.nodes[id].children[x]);
                this.hideChildren(this.myTree.nodes[id].children[x], id);
            }
        }
    }

    //This will add a node to the tree, in the appropriate this.column for the node to be in
    function addNodeToColumn(id,treeDepth)
    {
        var level = treeDepth - this.myTree.depth(id);
        if (this.myTree.nodes[id].children.length == 0)
        {
            level = 0;
        }

        while(level>=(this.columns.length))
        {
            this.columns.push([]);
            $('#'+this.divID).append('<ul class="tree_column" id="tree_col'+(this.columns.length-1)+'"></ul>');
        }
        
        if (this.columns[level].indexOf(id) < 0)
        {
            this.columns[level].push(id);
            this.myTree.nodes[id].column = level;
            //$('#tree_col'+level).append('<li tabindex=5 class="tree_node" id="tree_'+id+'" index='+id+'><p class="test_label"> ID:'+id+'<br/>Parent:'+this.myTree.nodes[id].parent+'</p></li><br/>  ');
            $('#tree_col'+level).append('<li tabindex=5 class="tree_node" id="tree_'+id+'" index='+id+'><p class="test_label whitetext">'+this.myTree.nodes[id].content+'</p></li><br/>  ');
            if (level != 0)
            {
                $('#tree_'+id).css("opacity", "0");
                this.myTree.nodes[id].hide();
            }
            
            $('#tree_'+id).click(this,function(e)
            {
                e.data.toggleParent($(this).attr("index"));
            });
            
            //to make this somewhat accessible, provide some keyboard navigation through tabbing and pressing enter
            $('#tree_'+id).keypress(function(e)
            {
                if (e.which == 13)
                {
                    $(this).click();
                }
            });
                    
        }
    }

    //Positions the nodes
    function updateNodePositions()
    {
        for (var j=0; j<this.columns.length; j++)
        {
            //Positioning loop
            for (var i=0; i<this.columns[j].length; i++)
            {
                if (j==0)
                {
                    continue;
                }
                childNodes = this.myTree.nodes[this.columns[j][i]].children;
                var numChildren = 0;
                var totY=0;

                for (var k=0; k<childNodes.length; k++)
                {
                    totY += $('#tree_'+childNodes[k]).offset().top;
                    numChildren += 1;
                }
                var avY=$('#tree_'+this.columns[j][i]).offset().top;
                var avY = totY/numChildren;
                var myY = $('#tree_'+this.columns[j][i]).offset().top;
                var offset = avY -myY;
                $('#tree_'+this.columns[j][i]).css("position", "relative");
                $('#tree_'+this.columns[j][i]).css("top", offset +"px");
                
                    
            }
        }
    }

    //Positions the lines
    function updateLines()
    {
        for (var j=0; j<this.columns.length; j++)
        {
                //Line drawing loop
            for (var n=0; n<this.columns[j].length;n++)
            {
                for (var m=0; m < this.myTree.nodes[this.columns[j][n]].children.length;m++)
                {
                    $('#'+this.divID+'').append('<div class="relation_line" id = "line_'+this.columns[j][n]+'b'+this.myTree.nodes[this.columns[j][n]].children[m]+'""></div>');
                    lineTop = $('#tree_'+this.myTree.nodes[this.columns[j][n]].id).position().top+ parseInt($('#tree_'+this.myTree.nodes[this.columns[j][n]].id).css("height"))/2 + parseInt($('#tree_'+this.myTree.nodes[this.columns[j][n]].id).css("margin-top"));
                    lineLeft = $('#tree_'+this.myTree.nodes[this.columns[j][n]].id).position().left+parseInt($('#tree_'+this.myTree.nodes[this.columns[j][n]].id).css("margin-left"));
                    $('#line_'+this.columns[j][n]+'b'+this.myTree.nodes[this.columns[j][n]].children[m]).css("top", lineTop);
                    $('#line_'+this.columns[j][n]+'b'+this.myTree.nodes[this.columns[j][n]].children[m]).css("left", lineLeft);
                    lineBottom = $('#tree_' + this.myTree.nodes[this.columns[j][n]].children[m]).position().top+ parseInt($('#tree_'+this.myTree.nodes[this.columns[j][n]].id).css("height"))/2 + parseInt($('#tree_'+this.myTree.nodes[this.columns[j][n]].id).css("margin-top"));
                    lineRight  = $('#tree_' + this.myTree.nodes[this.columns[j][n]].children[m]).position().left+ parseInt($('#tree_'+this.myTree.nodes[this.columns[j][n]].id).css("width")) + parseInt($('#tree_'+this.myTree.nodes[this.columns[j][n]].id).css("margin-top")) +3;
                    length = Math.sqrt((lineBottom-lineTop)*(lineBottom-lineTop) + (lineRight-lineLeft)*(lineRight-lineLeft));
                    $('#line_'+this.columns[j][n]+'b'+this.myTree.nodes[this.columns[j][n]].children[m]).css("height", length);
                    rotAngle = Math.acos((lineLeft-lineRight)/length);
                    if (lineTop <= lineBottom)
                    {
                        $('#line_'+this.columns[j][n]+'b'+this.myTree.nodes[this.columns[j][n]].children[m]).css("transform", 'rotate('+((Math.PI/2)-rotAngle)+'rad)');
                        $('#line_'+this.columns[j][n]+'b'+this.myTree.nodes[this.columns[j][n]].children[m]).css("-webkit-transform",'rotate('+((Math.PI/2)-rotAngle)+'rad)');
                        $('#line_'+this.columns[j][n]+'b'+this.myTree.nodes[this.columns[j][n]].children[m]).css("-ms-transform",'rotate('+((Math.PI/2)-rotAngle)+'rad)');
                        
                    }else{
                        $('#line_'+this.columns[j][n]+'b'+this.myTree.nodes[this.columns[j][n]].children[m]).css("transform", 'rotate('+((Math.PI/2)+rotAngle)+'rad)');
                        $('#line_'+this.columns[j][n]+'b'+this.myTree.nodes[this.columns[j][n]].children[m]).css("-webkit-transform", 'rotate('+((Math.PI/2)+rotAngle)+'rad)');
                        $('#line_'+this.columns[j][n]+'b'+this.myTree.nodes[this.columns[j][n]].children[m]).css("-ms-transform", 'rotate('+((Math.PI/2)+rotAngle)+'rad)');
                    }
                    $('#line_'+this.columns[j][n]+'b'+this.myTree.nodes[this.columns[j][n]].children[m]).css("opacity", "0");
                }
                
            }
        }
    }
}


/*Prototype of a node
 * 
 * hide() sets the node to be hidden
 * show() sets the node to be visible
 * parent - the single parent of a node
 * children - list of the ids of the node's children
 * column - the column in the tree display that the node is assigned to*/
function node(id, parent, content)
{
    this.id = id;
    this.content = content;
    this.parent = parent;
    this.children = new Array();
    this.hidden = false;
    this.hide = hide;
    this.show = show;
    this.added = false;
    this.column = -1;
    
    function hide()
    {
        this.hidden = true;
    }
    
    function show()
    {
        this.hidden = false;
    }
}


/*
 * addNode() - adds a new node that is the child of the node specified by parentID
 * depth() - gets the distance of a node from the root node
 * nodes - list of all the node objects in the tree
 * */
function tree()
{
    this.nodes = new Array();
    this.idCount = 0;
    this.addNode = addNode;
    this.depth = depth;
    this.addRoot = addRoot;
    
    function addRoot()
    {
        this.nodes['l'+this.idCount] = new node('l'+this.idCount,-1,this.idCount);
        this.idCount++;
    }

    function addNode(parentID)
    {
        this.nodes['l'+this.idCount] = new node('l'+this.idCount,'l'+parentID,this.idCount);
        this.nodes['l'+parentID].children.push(['l'+this.idCount]);
        this.idCount++;
    }

    function depth(ID)
    {
        if (ID[0] != 'l')
        {
            ID = 'l'+ID;
        }
        var depth = 0;
        var nextNode = this.nodes[ID];
        while (nextNode.parent != -1)
        {
            depth += 1;
            nextNode = this.nodes[nextNode.parent];
        }
        return depth;
    }
    
}
