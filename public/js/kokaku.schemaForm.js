/**
 * Module: SchemaForm
 * Description: Mainly use for generating dynamic form
 * Dependencies:
 *   local:
 *     - Flash
 *     - Statistic
 *   external:
 *     - jQuery
 *     - Nanobar.js
 *     - Mustache.js
 */
function SchemaForm() {
  // current scope
  var self = this;

  // jQuery DOM
  self.container = $(".items-wrap form");
  self.firstGroup = self.container.children(".group-1");
  self.secondGroup = self.container.children(".group-2");

  self.templateGeneric = $("#template-input-generic");
  self.templateInputSelect = $("#template-input-select");
  self.templateBtnAdd = $("#template-btn-add");
  self.buttonSave = $(".act-save");
  self.buttonUpdate = $(".act-update");
  self.buttonAddFile = $(".act-upload");

  // properties
  self.flash = new Flash();
  self.nanobar = new Nanobar({
    id: "nanobar"
  });

  // event handler
  $(document).on("click", ".btn-add", self.addField);
  this.buttonUpdate.on("click", function(e) { 
    e.preventDefault(); 
    self.submitForm("update"); 
    self.updateStatus(); 
  });
};

SchemaForm.prototype.statistic = null;
SchemaForm.prototype.id = null;

SchemaForm.prototype.init = function() {
  this.render();
};

SchemaForm.prototype.render = function() {
  var self = this;
  $.ajax({
    url: "http://localhost:8001/metadata/formSchema.json",
    method: "GET",
    dataType: "json",
    success: function(data) {
      self.drawForm(data);
    }
  });
};

SchemaForm.prototype.setValue = function(itemId) {
  var self = this;
  $.ajax({
    url: "http://localhost:8001/metadata/item/"+itemId,
    method: "GET",
    dataType: "json",
    progress: function() {
      self.nanobar.go(50);
    },
    success: function(data) {
      self.nanobar.go(100);
      if($.isEmptyObject(data)) {
        self.flash.show("error", "Data you've requested seems not exist. Are you trying to make a new submission?");
      } else {
        self.setId(data.id);
        self.setUpdateFormTitle(data);
        self.setUpdateStatus(data);
        self.fillForm(data, self);
      }
    }
  });
};

SchemaForm.prototype.setId = function (id) {
  this.id = id;
}

SchemaForm.prototype.updateStatus = function() {
  var self = this;
  var itemId = this.id;
  $.ajax({
    url: "http://localhost:8001/metadata/item/"+itemId,
    method: "GET",
    dataType: "json",
    progress: function() {
      self.nanobar.go(50);
    },
    success: function(data) {
      self.nanobar.go(100);
      if($.isEmptyObject(data)) {
        self.flash.show("error", "Data you've requested seems not exist. Are you trying to make a new submission?");
      } else {
        self.setUpdateFormTitle(data);
        self.setUpdateStatus(data);
      }
    }
  });
}

SchemaForm.prototype.setUpdateStatus = function(data) {
  var requiredProperties = ['title', 'number', 'docType', 'publishedDate', 'validDate', 'docUrl'];
  var c = 0;
  for(var it in data) {
    if(typeof data[it] === 'string') {
      if(($.inArray(it, requiredProperties) != -1) && (data[it] != '')) {
        c = c + 1;
      }
    }
  }
  $(".nav-content .status").removeClass('incomplete');
  $(".nav-content .status").removeClass('complete');
  
  if(c >= requiredProperties.length) {
    $(".nav-content .status span").text('complete');
    $(".nav-content .status").addClass('complete');
  } else {
    $(".nav-content .status span").text('incomplete');
    $(".nav-content .status").addClass('incomplete');
  }
}

SchemaForm.prototype.setUpdateFormTitle = function(data) {
  if(data.title != '') {
    var title = data.title;
  } else {
    var title = "(no title) "+data.originalFilename;
  }
  $(".nav-content .title").text(title);
}

SchemaForm.prototype.drawForm = function(data) {
  if (typeof data === 'object') {
    if (data.hasOwnProperty('properties')) {
      var source = data.properties;
      for(var key in source) {
        this.addElements(key, source[key]);
      }
    } else {
      throw "Parameter should has properties 'properties'.";
    }
  } else {
    throw "Function requires parameter as an object.";
  }
};

SchemaForm.prototype.fillForm = function(data, parentScope) {
  var source = data;
  for(var key in source) {
    parentScope.fillElements(key, source[key]);
  }
  parentScope.appendListFile(data);
};

SchemaForm.prototype.addElements = function(key, data) {
  if (typeof data === 'object') {
    if(data.enum) {
      this.addSelectElement(key, key, data);
    } else if(data.type == "array") {
      this.addFieldset(key, data);
    } else if(data.type == "object") {
      this.addFieldset(key, data);
    } else {
      this.addElement(key, key, data);
    }
  } else {
    throw 'Second parameter requires an object.';
  }
};

SchemaForm.prototype.appendListFile = function (data) {
  var listFile = $(".list-file");
  var template = 
  '<div class="file">\
  <div class="file-name">'+data.originalFilename+'</div>\
  </div>';
  var buttonAddFile = $(".act-upload");
  buttonAddFile.attr("disable", true);
  listFile.append($(template));
}

SchemaForm.prototype.fillElements = function (key, data) {
  if(typeof data === "string") {
    var str = ".input-"+key;
    this.container.children(".group-1").children(str).children("input, select").val(data);
  }
  if(typeof data == "object") { 
    this.fillArrayElement(key, data);
  }
}

SchemaForm.prototype.objectSize = function(obj) {
    var size = 0, key;
    for (key in obj) {
        if (obj.hasOwnProperty(key)) size++;
    }
    return size;
};

SchemaForm.prototype.fillArrayElement = function (key, data) {
  var index = 0;
  var size = this.objectSize(data);
  for (var item in data) {
    if(typeof data[item] === "object") {
      for (var it in data[item]) {
        var selector = ".input-"+it+" input[name='"+key+"."+index+"."+it+"']";
        $(selector).val(data[item][it]);
        if(it == 'id') {
          $(selector).parent().addClass("hidden");
        }
      }
    } else {
      var selector = ".input-"+item+" input[name='"+key+"."+item+"']";
      $(selector).val(data[item]);
      if(it == 'id') {
        $(selector).parent().addClass("hidden");
      }
    }
    index = index + 1;
    if(size > index) {
      $(".add-"+key).trigger("click");
    }
  }
}

SchemaForm.prototype.mustacheRender = function(html, data) {
  var template = html;
  Mustache.parse(template);
  return Mustache.render(template, data);
};

SchemaForm.prototype.addElement = function(key, cls, data) {
  if(typeof data === 'object') {
    if(data.hasOwnProperty('type')) {
      var elem = {
        class: cls,
        key: key,
        type: data.type
      };
      if(cls == 'id' || cls == 'originalFilename' || cls == 'filename') {
        elem.hidden = true;
      }
    } else {
      throw "Function requires third parameter to be object with 'type' properties.";
    }  
  } else {
    throw "Function requires third parameter to be object with 'type' properties.";
  }
  var template = this.templateGeneric.html();
  this.firstGroup.append(this.mustacheRender(template, elem));
};

SchemaForm.prototype.addSelectElement = function(key, cls, data) {
  if(typeof data === 'object') {
    if(data.hasOwnProperty('enum')) {
      var elem = {
        class: cls,
        key: key,
        enum: data.enum
      };
    } else {
      throw "Function requires third parameter to be object with 'enum' properties.";
    }
  } else {
    throw "Function requires third parameter to be object with 'enum' properties.";
  }
  var template = this.templateInputSelect.html();
  this.firstGroup.append(this.mustacheRender(template, elem));
};


SchemaForm.prototype.makeGenericElement = function(mold, key, cls, type) {
  var obj = {
    class: cls,
    key: key,
    type: type
  };
  if(cls == 'id') {
    obj.hidden = true;
  }
  var template = mold.html();
  return this.mustacheRender(template, obj);
};

SchemaForm.prototype.addFieldset = function(key, data, index) {
  var index = index || 0;
  var fieldset = $("<fieldset></fieldset>");
  var items = [];

  if(typeof data === 'object') {
    if(data.hasOwnProperty('type')) {
      var type = data.type;
    } else {
      throw "Function requires second parameter to be object with 'type' properties";
    }
  } else {
    throw "Function requires second parameter to be object with 'type' properties";
  }

  fieldset.append("<legend>"+key+"</legend>");

  if(type == 'object') {
    if(data.hasOwnProperty('properties')) {
      var source = data.properties;
    } else {
      throw "No properties 'properties' in second parameter object";
    }
    for (var it in source) {
      var html = this.addFieldsetObject(source[it], key, it);
      fieldset.append(html);
    }
    fieldset.attr("data-element", count);
  } else {
    var source = data.items;
    var count = 0;
    if(source.type == "object") {
      var prop = source.properties;
      for(var it in prop) {
        fieldset.append(this.makeGenericElement(this.templateGeneric, key+"."+index+"."+it, it, prop[it].type));
        count = count + 1;
      }
    } else {
      fieldset.append(this.makeGenericElement(this.templateGeneric, key+"."+index, key, source.type));
      count = 1;
    }
    var templateBtn = this.templateBtnAdd.html();
    fieldset.append(this.mustacheRender(templateBtn, { index: index, key: key }));
    fieldset.attr("data-element", count);
  }

  this.secondGroup.append(fieldset);
};

SchemaForm.prototype.addFieldsetObject = function(source, key, it) {
  if(source.enum) {
    var obj = {
      class: it,
      key: key+"."+it,
      enum: source.enum
    };
    var template = this.templateInputSelect.html();
    return this.mustacheRender(template, obj);
  } else {
    return this.makeGenericElement(this.templateGeneric, key+"."+it, it, source.type);
  }
};

$.fn.serializeObject = function() {
  var o = {};
  var a = this.serializeArray();
  $.each(a, function() {
    var split =  this.name.split(".")
    var key = split[0];

    if(split.length == 2) {
      var prop = split[1];
      // if prop is number, then element is array
      if(!isNaN(parseInt(prop))) {
        if(typeof o[key] === 'undefined') {
          o[key] = [];
        }
        if(typeof o[key][parseInt(prop)] === 'undefined') {
          obj = {};
          obj[key] = this.value;
          o[key].push(obj);
        } else {
          o[key][parseInt(prop)][key] = this.value;
        }
      } else { // if prop is not number, then element is object
        if(typeof o[key] === 'undefined') {
          o[key] = {};
        }
        o[key][prop] = this.value;
      }
    } 
    else if (split.length == 3) {
      var prop = split[2];
      var parent = split[1];

      if(typeof o[key] === 'undefined') {            
        o[key] = [];
      }
      if(typeof o[key][parseInt(parent)] === 'undefined') {
        obj = {};
        obj[prop] = this.value;
        o[key].push(obj);
      } else {
        o[key][parseInt(parent)][prop] = this.value;
      }
    } else {
      o[key] = this.value;
    }
  });
return o;
};

SchemaForm.prototype.submitForm = function(option, response) {
  var response = response || null;
  var data = this.container.serializeObject();
  var self = this;

  if(option == "new") {
    data.filename = response.filename;
    data.originalFilename = response.originalFilename;
    $.ajax({
      url: "http://localhost:8000/metadata",
      method: "POST",
      contentType: "application/json",
      data: JSON.stringify(data),
      progress: function() {
        self.nanobar.go(50);
      },
      success: function(data) {
        self.nanobar.go(100);
        self.statistic.getStat();
      },
      error: function(data) {
        console.log(data);
      }
    });
  } else {
    var id = data.id;
    $.ajax({
      url: "http://localhost:8000/metadata/" + id,
      method: "PUT",
      contentType: "application/json",
      data: JSON.stringify(data),
      progress: function() {
        self.nanobar.go(50);
      },
      success: function(data) {
        self.nanobar.go(100);
        self.statistic.getStat();
        self.flash.show("success", data);
      },
      error: function(data) {
        console.log(data);
      }
    });
  }
};

SchemaForm.prototype.getFormValue = function() {
  return this.container.serializeObject();
}

SchemaForm.prototype.addField = function() {
  var target = $(this);
  var index = parseInt(target.parent().attr("data-index"));
  var fieldset = target.parent().parent();
  var limit = parseInt(fieldset.attr("data-element"));
  var piv = fieldset.children(".act-input");
  var inputs = fieldset.children(".input");
  var count = 0;
  var self = this;

  $.each(inputs, function() {
    if(count < limit) {
      var el = $(this).clone();
      var name = el.children("input").attr("name");
      var split = name.split(".");
      split[1] = index + 1;
      var join = split.join(".");
      el.children("input").attr("name", join);
      el.children("label").attr("for", join);
      if(limit > 1) {
        piv.before("<div class='input input-"+split[2]+"'>"+el.html()+"</div>");
      } else {
        piv.before("<div class='input input-"+split[0]+"'>"+el.html()+"</div>");
      }
      count = count + 1;
    } else {
      return false;
    }
  });

  target.parent().attr("data-index", index + 1);
};

SchemaForm.prototype.makeFieldElement = function(source) {
  var el = source.clone();
  var name = el.children("input").attr("name");
  var split = name.split(".");
  split[1] = index + 1;
  var join = split.join(".");
  el.children("input").attr("name", join);
  el.children("label").attr("for", join);

  return el;
};

SchemaForm.prototype.setStat = function(Stat) {
  this.statistic = Stat;
}