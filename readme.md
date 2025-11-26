# Bootstrap Document Downloads

**Description:** Manage and display downloadable files (PDF, DOC, XLS) in a responsive grid.  
**Version:** 1.0  
**Author:** D Kandekore  

## Features
* **Custom Post Type:** "Download Items" to manage your files separately from posts.
* **Direct Downloads:** Buttons automatically include the `download` attribute.
* **Custom Fields:** Paste file URLs directly from your media library.
* **Global Styling:** Customize colors and the "Download Button" content (icons/text) centrally.

## Installation
1.  Upload the `bootstrap-doc-downloads` folder to `/wp-content/plugins/`.
2.  Activate the plugin in WordPress.
3.  Go to **Download Items > Display Settings** to configure colors.

## Usage

### 1. Adding a Download
1.  Go to **Download Items > Add New**.
2.  **Title:** Enter the document name.
3.  **Content:** Enter a description.
4.  **Featured Image:** Upload a preview image (e.g., a PDF cover or generic icon).
5.  **File Details (Meta Box):**
    * **File URL:** Paste the full URL of the file (Go to Media > Library, click a file, copy "File URL").
    * **Card Icon Class:** A Font Awesome class (e.g., `fa-solid fa-file-pdf`) for the decorative divider.

### 2. Displaying Downloads

#### Method A: Shortcode
`[bootstrap_downloads category="brochures" columns="3" limit="6"]`

* `category`: Slug of the category.
* `columns`: Number of items per row.

#### Method B: Elementor Widget
1.  Edit a page with Elementor.
2.  Search for **Bootstrap Document Downloads**.
3.  Drag to page and configure settings.

## Configuration
Go to **Download Items > Display Settings** to change:
* **Colors:** Border, Divider, Background, Button.
* **Button Content:** You can paste HTML here.
    * *Default:* `<i class="fa-solid fa-download"></i> Download`
    * *Icon Only:* `<i class="fa-solid fa-download" style="font-size:1.5rem;"></i>`