<nav class="nav-content">
  @if($route == 'metadata')
  <span class="act-orderBy">
  <p>order by<i class="fa fa-angle-down"></i></p>
    <ul id="sort-options" class="options">
      <li class="docType-asc" data-type="docType" data-order="asc">type A-Z</li>
      <li class="docType-desc" data-type="docType" data-order="desc">type Z-A</li>
      <li class="publishedDate-desc" data-type="publishedDate" data-order="desc">recent published</li>
      <li class="publishedDate-asc" data-type="publishedDate" data-order="asc">oldest published</li>
      <li class="created_at-desc" data-type="created_at" data-order="desc">recent created</li>
      <li class="created_at-asc" data-type="created_at" data-order="asc">oldest created</li>
    </ul>
  </span>
  @else
  <span class="act-tabs">
    <nav>
      <ul class="lists">
        <li class="tab-main tab active">Main</li>
        <li class="tab-optional tab">Additional</li>
        <li class="tab-file tab">File</li>
      </ul>
    </nav>
  </span>
  <span class="status"><span></span></span>
  <span class="title"></span>
  @endif
</nav>