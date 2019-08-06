function e(msg) {
    console.log(msg)
}
function _(id) {
    return document.getElementById(id);
}
function $(selector) {

    if (typeof selector == "string"){
        
        this.element = document.querySelectorAll(selector);
    }
    else if (typeof selector == "object") {
        if (selector.hasOwnProperty("hide")) {
            
            this.element = selector.element.slice();
        } else {
            
            this.element[0] = selector;
        }
        
    }
    this.CUSTOME = function() {
    };
//Start Private Function

    this._getStyle = function(el, styleProp) {
        var value, defaultView = (el.ownerDocument || document).defaultView;
        if (defaultView && defaultView.getComputedStyle) {
            styleProp = styleProp.replace(/([A-Z])/g, "-$1").toLowerCase();
            return defaultView.getComputedStyle(el, null).getPropertyValue(styleProp);
        } else if (el.currentStyle) {
            styleProp = styleProp.replace(/\-(\w)/g, function(str, letter) {
                return letter.toUpperCase();
            });
            value = el.currentStyle[styleProp];
            if (/^\d+(em|pt|%|ex)?$/i.test(value)) {
                return (function(value) {
                    var oldLeft = el.style.left, oldRsLeft = el.runtimeStyle.left;
                    el.runtimeStyle.left = el.currentStyle.left;
                    el.style.left = value || 0;
                    value = el.style.pixelLeft + "px";
                    el.style.left = oldLeft;
                    el.runtimeStyle.left = oldRsLeft;
                    return value;
                })(value);
            }
            return value;
        }
    }

//End Private Function
//Public Function
    this.elements = function() {
        return this.element;
    }
    this.dump = function() {
        console.log(this.element);
    }
    this.hide = function() {
        for (var i = 0; i < this.element.length; i++) {
            this.element[i].style.display = "none";
        }
        return this;
    }
    this.show = function() {
        for (var i = 0; i < this.element.length; i++) {
            this.element[i].style.display = "block";
        }
        return this;
    }
    this.toggle = function() {
        for (var i = 0; i < this.element.length; i++) {
            var tmp = this.element[i];
            if (this._getStyle(tmp, "display") == "none") {
                tmp.style.display = "block";
            } else {
                tmp.style.display = "none";
            }
        }
        return this;
    }
    this.text = function() {
        if (arguments.length == 0) {
            return this.element[0].innerHTML;
        } else {
            for (var i = 0; i < this.element.length; i++) {
                var tmp = this.element[i];
                tmp.innerHTML = arguments[0];
            }
            return this;
        }
    }
    this.replace = function() {
        for (var i = 0; i < this.element.length; i++) {
            var tmp = this.element[i];
            tmp.outerHTML = arguments[0];
        }
        return this;
    }
    this.remove = function() {
        for (var i = 0; i < this.element.length; i++) {
            var tmp = this.element[i];
            tmp.outerHTML = "";
        }
        return this;
    }
    this.append = function() {
        for (var i = 0; i < this.element.length; i++) {
            var tmp = this.element[i];
            tmp.innerHTML = tmp.innerHTML + arguments[0];
        }
        return this;
    }
    this.appendStart = function() {
        for (var i = 0; i < this.element.length; i++) {
            var tmp = this.element[i];
            tmp.innerHTML = arguments[0] + tmp.innerHTML;
        }
        return this;
    }
    this.css = function() {
        if (arguments.length === 2) {
            for (var i = 0; i < this.element.length; i++) {
                var tmp = this.element[i];
                tmp.style.cssText += ";" + arguments[0] + ":" + arguments[1] + ";";
            }
        } else if (arguments.length === 1) {
            if (!(arguments[0].search(":") >= 0 || arguments[0].search(";") >= 0)) {
                return this._getStyle(this.element[0], arguments[0]);
            } else {
                for (var i = 0; i < this.element.length; i++) {
                    var tmp = this.element[i];
                    tmp.style.cssText += ";" + arguments[0] + ";";
                }
            }
        }
        return this;
    }

    this.attr = function() {
        if (arguments.length === 2) {
            for (var i = 0; i < this.element.length; i++) {
                var tmp = this.element[i];
                tmp.setAttribute(arguments[0], arguments[1])
            }
        } else if (arguments.length === 1) {
            e("ATTR " + this.element.length)
            if (this.element.length > 0) {
                var tmp = this.element[this.element.length - 1];
               
                return tmp.getAttribute(arguments[0]);
            }else{
                return;
            }
        }
        return this;
    }

    this.val = function() {
        if (arguments.length === 1) {
            for (var i = 0; i < this.element.length; i++) {
                var tmp = this.element[i];
                tmp.value = arguments[0];
            }
        } else if (arguments.length === 0) {
            return this.element[0].value;
        }
        return this;
    }
    this.on = function() {
        for (var i = 0; i < this.element.length; i++) {
            var tmp = this.element[i];
            tmp.addEventListener(arguments[0], arguments[1].bind(tmp));
        }
        return this;
    }
    this.removeOn = function() {
        for (var i = 0; i < this.element.length; i++) {
            var tmp = this.element[i];
            tmp.removeEventListener(arguments[0], arguments[1].bind(tmp));
        }
        return this;
    }
    this.addClass = function() {
        for (var i = 0; i < this.element.length; i++) {
            var tmp = this.element[i];
            tmp.classList.add(arguments[0]);
        }
        return this;
    }
    this.removeClass = function() {
        for (var i = 0; i < this.element.length; i++) {
            var tmp = this.element[i];
            tmp.classList.remove(arguments[0]);
        }
        return this;
    }
    this.child = function() {
        if (typeof arguments[0] === "object") {
            if (arguments[0].hasOwnProperty("CUSTOME")) {
                this.element = arguments[0].element;
            } else {
                var tmpElement = array();
                for (var i = 0; i < this.element.length; i++) {
                    var tmp = this.element[i];
                    tmpElement.push.apply(temElement, tmp.querySelectorAll(arguments[0]));
                }
                this.element = tmpElement;
            }
        } else {
            this.element = arguments[0];
        }
        return this;
    }
    this.each = function() {
        var functionname = arguments[0];
        for (var i = 0; i < this.element.length; i++) {
            var tmp = this.element[i];
            var anotherfun = functionname.bind(tmp);
            anotherfun();
        }
        return this;
    }
    this.ajax = function() {
        var args = arguments[0];
        if (typeof args == "undefined") {
            args = {};
        }
        if (!args.hasOwnProperty("type")) {
            args.type = "get";
        }
        if (!args.hasOwnProperty("url")) {
            args.url = "/";
        }
        if (!args.hasOwnProperty("async")) {
            args.async = false;
        }
        if (!args.hasOwnProperty("args")) {
            args.args = "";
        }
        if (!args.hasOwnProperty("readystatechange")) {
            args.readystate = function() {
            };
        }


        return this;
    }



    return this;
}

function get(e) {
    var t = new XMLHttpRequest;
    return t = window.XMLHttpRequest ? new XMLHttpRequest : new ActiveXObject("Microsoft.XMLHTTP"), t.open("GET", e, !1), t.send(), t.responseText
}
function post(e, t, n, r) {
    return("false" == typeof r || "undefined" == typeof r) && (r = function() {
    }), "false" == typeof n | "undefined" == typeof n && (n = !1), xmlhttp = window.XMLHttpRequest ? new XMLHttpRequest : new ActiveXObject("Microsoft.XMLHTTP"), xmlhttp.open("POST", e, n), xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"), xmlhttp.onreadystatechange = r.bind(xmlhttp), xmlhttp.send(t), xmlhttp
}
function trim(e, t) {
    return"false" == typeof t && (t = 5), e = e.substr(0, t)
}
function changeAddr(e) {
    window.history.pushState("", "", e);
    
}

;

