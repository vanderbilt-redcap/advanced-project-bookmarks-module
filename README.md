## Advanced Project Bookmarks

This module currently only facilitates creating bookmarks to other projects on the same REDCap instance that have records matching the records on the current project (based on record ID).  It could be expanded to include other functionality in the future.  It currently does the following for bookmarks that link back to the current REDCap URL:

 - Changes the 'record' parameter to an 'id' parameter (it is assumed that the linked project has matching records with the same record IDs).
 - Hides any bookmarks that contain an 'id' parameter if the current page is not record specific.