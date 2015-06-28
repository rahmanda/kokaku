<html>
  <head>
    <meta charset="utf-8">
    <title>Upload</title>
  </head>
  <body>
    <form action="{{ url('upload') }}" method="POST" enctype="multipart/form-data">
      <input type="file" name="doc" placeholder="Upload file">
      <input type="submit" value="upload">
    </form>
  </body>
</html>