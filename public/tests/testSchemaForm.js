QUnit.module("SchemaForm");

QUnit.test("init", function() {
  var schemaForm = new SchemaForm();
  schemaForm.render = sinon.spy();
  schemaForm.init();
  QUnit.assert.ok(schemaForm.render.called, "SchemaForm.render() should be called.");
});

QUnit.test("drawForm", function() {
  var schemaForm = new SchemaForm();
  schemaForm.addElements = sinon.spy();

  var data = '';
  QUnit.assert.throws(function() { schemaForm.drawForm(data) },  
    "SchemaForm.drawForm(data) should throw message if parameter is not an object (string).");

  var data = null;
  QUnit.assert.throws(function() { schemaForm.drawForm(data) },  
    "SchemaForm.drawForm(data) should throw message if parameter is not an object (null).");

  var data = {};
  QUnit.assert.throws(function() { schemaForm.drawForm(data) },
    "SchemaForm.drawForm(data) should throw message if parameter has not properties 'properties'.");

  var data = {
    properties: []
  };
  schemaForm.drawForm(data);
  QUnit.assert.notOk(schemaForm.addElements.called, "SchemaForm.addElements() shouldn't be called because data.properties is an empty array.");
  
  data.properties = [1,2,3];
  schemaForm.drawForm(data);
  QUnit.assert.ok(schemaForm.addElements.called, "SchemaForm.addElements should be called because data.properties is not an empty array.");
});

QUnit.test("fillForm", function() {
  var schemaForm = new SchemaForm();
  schemaForm.fillElements = sinon.spy();

  var data = [1,2,3];
  schemaForm.fillForm(data);
  QUnit.assert.ok(schemaForm.fillElements.called, "SchemaForm.fillElements should be called");
});

QUnit.test("addElements", function() {
  var schemaForm = new SchemaForm();
  schemaForm.addSelectElement = sinon.spy();
  schemaForm.addFieldset = sinon.spy();
  schemaForm.addElement = sinon.spy();

  var data = '';
  var key = 'foo';
  QUnit.assert.throws(function() { schemaForm.addElements(key, data); },
    "SchemaForm.addElements(data, key) should throw message if first parameter is not an object (string).");

  data = {
    enum: 'bar'
  };
  schemaForm.addElements(key, data);
  QUnit.assert.ok(schemaForm.addSelectElement.called, "SchemaForm.addSelectElements() should be called when it is provided by enum properties on data object.");

  data = {
    type: 'array'
  };
  schemaForm.addElements(key, data);
  QUnit.assert.ok(schemaForm.addFieldset.called, "SchemaForm.addFieldset() should be called when it is provided by 'array' type properties on data object.");

  data = {
    type: 'object'
  };
  schemaForm.addElements(key, data);
  QUnit.assert.ok(schemaForm.addFieldset.called, "SchemaForm.addFieldset() should be called when it is provided by 'object' type properties on data object.");

  data = {};
  schemaForm.addElements(key, data);
  QUnit.assert.ok(schemaForm.addElement.called, "SchemaForm.addFieldset() should be called for other object.")
});

QUnit.test("addElement", function() {
  var schemaForm = new SchemaForm();
  var key = '';
  var cls = '';
  var data = '';
  schemaForm.mustacheRender = sinon.spy();

  QUnit.assert.throws(function() { schemaForm.addElement(key, cls, data); },
   "SchemaForm.addElement() should throw message if third parameter is not an object");

  data = {};
  QUnit.assert.throws(function() { schemaForm.addElement(key, cls, data); },
  "SchemaForm.addElement() should throw message if third parameter has not properties 'type'.");

  data = {
    type: 'bar'
  };
  var response = schemaForm.addElements(key, data);
  QUnit.assert.ok(schemaForm.mustacheRender.called, "SchemaForm.mustacheRender() should be called.");
});

QUnit.test("addSelectElement", function() {
  var schemaForm = new SchemaForm();
  var key = '';
  var cls = '';
  var data = '';
  schemaForm.mustacheRender = sinon.spy();

  QUnit.assert.throws(function() { schemaForm.addSelectElement(key, cls, data); },
  "SchemaForm.addSelectElement() should throw message if third parameter is not an object");

  data = {};
  QUnit.assert.throws(function() { schemaForm.addSelectElement(key, cls, data); },
  "SchemaForm.addSelectElement() should throw message if third parameter has not properties 'enum'.");

  data = {
    enum: []
  };
  schemaForm.addSelectElement(key, cls, data);
  QUnit.assert.ok(schemaForm.mustacheRender.called, "SchemaForm.mustacheRender() should be called.");
});

QUnit.test("makeGenericElement", function () {
  var schemaForm = new SchemaForm();
  schemaForm.mustacheRender = sinon.spy();
  var mold, key, cls, type;
  mold = $("<html></html>");
  schemaForm.makeGenericElement(mold, key, cls, type);
  QUnit.assert.ok(schemaForm.mustacheRender.called, "SchemaForm.mustacheRender() should be called.");
});

QUnit.test("addFieldset", function () {
  var schemaForm = new SchemaForm();
  var key, data, index;
  schemaForm.addFieldsetObject = sinon.spy();

  QUnit.assert.throws(function() { schemaForm.addFieldset(key, data, index); },
    "SchemaForm.addFieldset() should throw message if second parameter is not an object");

  data = {};
  QUnit.assert.throws(function() { schemaForm.addFieldset(key, data, index); },
    "SchemaForm.addFieldset() should throw message if second parameter has not properties 'type'");

  data = {
    type: ''
  };
});