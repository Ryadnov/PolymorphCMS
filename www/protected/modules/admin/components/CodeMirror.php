<?php
class CodeMirror extends CWidget 
{
	public $type = null;
	
	public $id = null;
	public $form = null;
	public $model = null;
	public $attr = null;

	public $content = null;
	public $name = null;
    
	public function run() 
    {
    	if (!in_array($this->type, array('text/html', 'css', 'javascript', 'xml'))) {
			throw new CException("type принемает значения: 'text/html', 'css', 'javascript', 'xml'");
		}
		
    	if ($this->content === null) {
			if (!($this->id && $this->form && $this->model && $this->attr))
				throw new CException("Обязательные поля для CodeMirror: id, form, model, attr");
    	}
    	
    	Y::clientScript()
    		->registerScriptFile('/js/CodeMirror/lib/codemirror.js')
			->registerCssFile('/js/CodeMirror/lib/codemirror.css')
			->registerScriptFile('/js/CodeMirror/mode/javascript/javascript.js')
			->registerCssFile('/js/CodeMirror/mode/javascript/javascript.css')
			->registerScriptFile('/js/CodeMirror/mode/css/css.js')
			->registerCssFile('/js/CodeMirror/mode/css/css.css')
			->registerScriptFile('/js/CodeMirror/mode/xml/xml.js')
			->registerCssFile('/js/CodeMirror/mode/xml/xml.css')
			->registerScriptFile('/js/CodeMirror/mode/htmlmixed/htmlmixed.js')
			->registerScriptFile('/js/CodeMirror/lib/overlay.js')	
        	->registerScript('autocomplete_'.$this->id, '
        	$(document).ready(function() {
			  // autocomplite
			  function stopEvent() {
			    if (this.preventDefault) {this.preventDefault(); this.stopPropagation();}
			    else {this.returnValue = false; this.cancelBubble = true;}
			  }
			  function addStop(event) {
			    if (!event.stop) event.stop = stopEvent;
			    return event;
			  }
			  function connect(node, type, handler) {
			    function wrapHandler(event) {handler(addStop(event || window.event));}
			    if (typeof node.addEventListener == "function")
			      node.addEventListener(type, wrapHandler, false);
			    else
			      node.attachEvent("on" + type, wrapHandler);
			  }

			  function forEach(arr, f) {
			    for (var i = 0, e = arr.length; i < e; ++i) f(arr[i]);
			  }
			  var startComplete = function () {
			    // We want a single cursor position.
			    if ('.$this->id.'_CM_editor.somethingSelected()) return;
			    // Find the token at the cursor
			    var cur = '.$this->id.'_CM_editor.getCursor(false), token = '.$this->id.'_CM_editor.getTokenAt(cur), tprop = token;
			    if (!/^[\w$_]*$/.test(token.string)) {
			      token = tprop = {start: cur.ch, end: cur.ch, string: "", state: token.state,
			                       className: token.string == "." ? "js-property" : null};
			    }
			    // If it is a property, find out what it is a property of.
			    while (tprop.className == "js-property") {
			      tprop = '.$this->id.'_CM_editor.getTokenAt({line: cur.line, ch: tprop.start});
			      if (tprop.string != ".") return;
			      tprop = '.$this->id.'_CM_editor.getTokenAt({line: cur.line, ch: tprop.start});
			      if (!context) var context = [];
			      context.push(tprop);
			    }
			    var completions = getCompletions(token, context);
			    if (!completions.length) return;
			    function insert(str) {
			      '.$this->id.'_CM_editor.replaceRange(str, {line: cur.line, ch: token.start}, {line: cur.line, ch: token.end});
			    }
			    // When there is only one completion, use it directly.
			    if (completions.length == 2) {insert(completions[0]); return true;}

			    // Build the select widget
			    var complete = document.createElement("div");
			    complete.className = "completions";
			    var sel = complete.appendChild(document.createElement("select"));
			    sel.multiple = true;
			    for (var i = 0; i < completions.length; ++i) {
			      var opt = sel.appendChild(document.createElement("option"));
			      opt.appendChild(document.createTextNode(completions[i]));
			    }
			    sel.firstChild.selected = true;
			    sel.size = Math.min(10, completions.length);
			    var pos = '.$this->id.'_CM_editor.cursorCoords();
			    complete.style.left = pos.x + "px";
			    complete.style.top = pos.yBot + "px";
			    document.body.appendChild(complete);
			    // Hack to hide the scrollbar.
			    if (completions.length <= 10)
			      complete.style.width = (sel.clientWidth - 2) + "px";

			    var done = false;
			    function close() {
			      if (done) return;
			      done = true;
			      complete.parentNode.removeChild(complete);
			    }
			    function pick() {
			      insert(sel.options[sel.selectedIndex].value);
			      close();
			      setTimeout(function(){'.$this->id.'_CM_editor.focus();}, 50);
			    }
			    connect(sel, "blur", close);
			    connect(sel, "keydown", function(event) {
			      var code = event.keyCode;
			      // Enter and space
			      if (code == 13 || code == 32) {event.stop(); pick();}
			      // Escape
			      else if (code == 27) {event.stop(); close(); '.$this->id.'_CM_editor.focus();}
			      else if (code != 38 && code != 40) {close(); '.$this->id.'_CM_editor.focus(); setTimeout(startComplete, 50);}
			    });
			    connect(sel, "dblclick", pick);

			    sel.focus();
			    // Opera sometimes ignores focusing a freshly created node
			    if (window.opera) setTimeout(function(){if (!done) sel.focus();}, 100);
			    return true;
			  }

			  var stringProps = ("charAt charCodeAt indexOf lastIndexOf substring substr slice trim trimLeft trimRight " +
			                     "toUpperCase toLowerCase split concat match replace search").split(" ");
			  var arrayProps = ("length concat join splice push pop shift unshift slice reverse sort indexOf " +
			                    "lastIndexOf every some filter forEach map reduce reduceRight ").split(" ");
			  var funcProps = "prototype apply call bind".split(" ");
			  var keywords = ("break case catch continue debugger default delete do else false finally for function " +
			                  "if in instanceof new null return switch throw true try typeof var void while with").split(" ");

			  function getCompletions(token, context) {
			    var found = [], start = token.string;
			    function maybeAdd(str) {
			      if (str.indexOf(start) == 0) found.push(str);
			    }
			    function gatherCompletions(obj) {
			      if (typeof obj == "string") forEach(stringProps, maybeAdd);
			      else if (obj instanceof Array) forEach(arrayProps, maybeAdd);
			      else if (obj instanceof Function) forEach(funcProps, maybeAdd);
			      for (var name in obj) maybeAdd(name);
			    }

			    if (context) {
			      // If this is a property, see if it belongs to some object we can
			      // find in the current environment.
			      var obj = context.pop(), base;
			      if (obj.className == "js-variable")
			        base = window[obj.string];
			      else if (obj.className == "js-string")
			        base = "";
			      else if (obj.className == "js-atom")
			        base = 2;
			      while (base != null && context.length)
			        base = base[context.pop().string];
			      if (base != null) gatherCompletions(base);
			    }
			    else {
			      // If not, just look in the window object and any local scope
			      // (reading into JS mode internals to get at the local variables)
			      for (var v = token.state.localVars; v; v = v.next) maybeAdd(v.name);
			      gatherCompletions(window);
			      forEach(keywords, maybeAdd);
			    }
			    return found;
			  }

			var myTextArea = document.getElementById("'.$this->id.'");
			'.$this->id.'_CM_editor = CodeMirror.fromTextArea(myTextArea,{
				mode: "'.$this->type.'",
				lineNumbers: true,
				tabMode: "indent",
				undoDepth: 500,
				onKeyEvent: function(i, e) {
			      // Hook into ctrl-space
			      if (e.keyCode == 32 && (e.ctrlKey || e.metaKey) && !e.altKey) {
			        e.stop();
			        return startComplete();
			      }
			    }
			});
		});');
        	
		if ($this->content !== null)
			echo CHtml::textArea($this->name, $this->content, array('id'=>$this->id));
		else
			echo $this->form->textArea($this->model,$this->attr,array('id'=>$this->id));
    }
}
