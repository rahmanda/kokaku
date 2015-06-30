/**
 * Module: Upload
 * Description: upload file handling
 * Dependencies:
 *   local:
 *     - SchemaForm
 *   external:
 *     - jQuery
 *     - Nanobar.js
 */

function Upload () {
    var self = this;
    var setting = {
      url: "http://localhost:8001/upload",
      acceptFileTypes: /(\.|\/)pdf$/i,
      add: function(e, data) {
        self.add(e, data);
      },
      progressall: function(e, data) {
        var progress = parseInt(data.loaded / data.total * 100, 10);
        self.nanobar.go(progress);
      },
      done: function(e, data) {
        self.done(e, data);
      }
    };

    self.listFile.bind("changeContent", function() {
      if(self.utils.isContainNoHTML($(this))) {
        self.buttonAddFile.attr("disable", true);
      }
    }); 

    this.buttonAddFile.on("click", function(e){
      e.preventDefault();
      if($(this).attr("disable") != 'true') {
        self.uploadForm.trigger("click");
        self.totalFile = self.totalFile + 1;
      }
    });

    this.uploadForm.fileupload(setting);
}

Upload.prototype.uploadForm = $("#fileupload");
Upload.prototype.progress = $(".act-upload-progress p");
Upload.prototype.progressBar = $(".prog-upload");
Upload.prototype.buttonSave = $(".act-save");
Upload.prototype.listFile = $(".list-file");
Upload.prototype.buttonAddFile = $(".act-upload");
Upload.prototype.form = null;
Upload.prototype.totalFile = 0;
Upload.prototype.utils = new Utils();

Upload.prototype.nanobar = new Nanobar({
  id: "nanobar"
});

Upload.prototype.flash = new Flash();

Upload.prototype.fileCount = 0;

Upload.prototype.getSetting = {
    url: "http://localhost:8001/upload",
    acceptFileTypes: /(\.|\/)pdf$/i,
    add: this.add,
    progressAll: this.progressFile,
    done: this.done
};

Upload.prototype.getReadableFileSizeString = function(fileSizeInBytes) {
  var i = -1;
  var byteUnits = [' kB', ' MB', ' GB', ' TB', 'PB', 'EB', 'ZB', 'YB'];
  do {
    fileSizeInBytes = fileSizeInBytes / 1024;
    i++;
  } while (fileSizeInBytes > 1024);

  return Math.max(fileSizeInBytes, 0.1).toFixed(1) + byteUnits[i];
};

Upload.prototype.incrementFileCount = function() {
  this.fileCount = this.fileCount + 1;
  return this.fileCount;
}

Upload.prototype.appendProgressUpload = function (index, file) {
  var progressTemplate = 
  '<li class="item-upload">\
  <div class="file-name">'+file.name+'</div>\
  <div class="file-prog">'+this.getReadableFileSizeString(file.size)+'</div>\
  <div class="act-cancel">\
  <span class="btn btn-remove"></span>\
  </div>\
  </li>'; 
  this.progressBar.append($(progressTemplate));
}

Upload.prototype.appendListFile = function (file) {
  var template = 
  '<div class="file">\
  <div class="file-name">'+file.name+'</div>\
  <div class="file-size">'+this.getReadableFileSizeString(file.size)+'</div>\
  </div>';
  this.listFile.append($(template));
}

Upload.prototype.add = function (e, data) {
  var self = this;
  self.listFile.trigger("changeContent"); 
  $.each(data.files, function(index, file) {
    self.appendListFile(file);
  });
  self.buttonSave.on("click", function() { 
    var formData = self.form.getFormValue();
    if(formData.publishedDate !== '') {
      data.formData = { date: formData.publishedDate };
      data.submit(); 
    } else {
      self.flash.show("error", "Please at least fill publishedDate field before saving.");
    } 
  });
};

Upload.prototype.progressFile = function (e, data) {
  var progress = parseInt(data.loaded / data.total * 100, 10);

  this.nanobar.go(progress);
}

Upload.prototype.done = function(e, data) {
  this.flash.show("success");
  this.form.submitForm("new", data.result.data);
}

Upload.prototype.upload = function(url) {
  this.uploadForm.fileupload(this.getSetting(url));
}

Upload.prototype.setForm = function(Form) {
  this.form = Form;
}