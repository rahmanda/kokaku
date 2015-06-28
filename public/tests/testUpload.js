QUnit.module("Upload");

QUnit.test("getSetting", function () {
  var upload = new Upload();

  var setting = upload.getSetting('someurl');
  var exist = typeof setting === 'object' ? true : false;
  QUnit.assert.ok(exist, "Upload.getSetting() should return object.");

  var url = setting.url;
  QUnit.assert.ok(url == 'someurl' ? true : false, "Upload.getSetting() return object should return the same url as given parameter");
});

QUnit.test("getReadableFileSizeString", function() {
  var upload = new Upload();

  var filesize = upload.getReadableFileSizeString(1000); // in b?

  QUnit.assert.ok(filesize == '1.0 kB' ? true : false, "Function should return 0.1 kB if the given parameter is 100");

  filesize = upload.getReadableFileSizeString(10000000);
  QUnit.assert.ok(filesize == '9.5 MB' ? true : false, "Function should return 9.5 MB if the given parameter is 10000000");
});

QUnit.test("incrementFileCount", function() {
  var upload = new Upload();

  upload.incrementFileCount();

  QUnit.assert.ok(upload.fileCount == 1 ? true : false, "Function should increment fileCount by 1");

  upload.incrementFileCount();
  QUnit.assert.ok(upload.fileCount == 2 ? true : false, "Function should increment fileCount by 1");
});

