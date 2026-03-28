# Bootstrap Document Downloads (v1.0)

A professional WordPress plugin designed to manage and display downloadable files (PDFs, Documents, Spreadsheets) in a clean, responsive Bootstrap-powered grid. This plugin is ideal for creating resource centers, document libraries, or brochure download sections with centralized styling and easy management.

---

## 🚀 Key Features

* **Dedicated Management**: Uses a "Download Items" Custom Post Type to keep your downloadable assets separate from standard blog posts and pages.
* **Smart Categorization**: Organizes files with a custom "Download Categories" taxonomy, allowing you to display specific groups of files in different sections of your site.
* **Dynamic Bootstrap Grid**: Automatically generates a responsive layout that adapts to all screen sizes.
* **Centralized Global Styling**: A dedicated settings page allows you to control the entire aesthetic—including border, divider, background, and button colors—without touching any code.
* **Customizable Download Buttons**: Support for HTML in button content, enabling the use of Font Awesome icons and custom text globally.
* **Elementor Integration**: Includes a native Elementor widget for a seamless "drag-and-drop" design experience.

---

## 🛠 Installation

1.  **Upload**: Upload the `bootstrap-doc-downloads` folder to the `/wp-content/plugins/` directory.
2.  **Activate**: Navigate to the **Plugins** menu in your WordPress dashboard and click **Activate**.
3.  **Configure**: Go to **Download Items > Display Settings** to set your brand colors and button preferences.

---

## 📖 How to Use

### 1. Adding a Download Item
1.  Navigate to **Download Items > Add New**.
2.  **Title**: Enter the name of the document.
3.  **Content**: Provide a brief description. You can limit the displayed length of this text in the settings.
4.  **Featured Image**: Upload a preview image, such as a PDF cover. If left blank, the plugin uses a global default image or a placeholder.
5.  **File Details (Meta Box)**:
    * **File URL**: Paste the direct link to the file from your **Media Library**.
    * **Card Icon Class**: Enter a Font Awesome class (e.g., `fa-solid fa-file-pdf`) to display a decorative icon on the card's divider.

### 2. Displaying the Grid

#### Method A: Using Shortcodes
Use the following shortcode on any page or post:
`[bootstrap_downloads category="slug" columns="3" limit="9"]`

* **`category`**: The slug of the specific category you want to show (leave blank for all).
* **`columns`**: Number of items per row (e.g., 2, 3, or 4).
* **`limit`**: Total number of items to display.

#### Method B: Elementor Widget
1.  Open any page in the **Elementor** editor.
2.  Search for the **Bootstrap Document Downloads** widget.
3.  Drag the widget onto your page and use the controls to select categories, column counts, and item limits.

---

## 🎨 Global Configuration
Access these settings via **Download Items > Display Settings** to maintain a consistent look across your site:

* **Design Colors**: Customize the **Border**, **Divider**, **Background**, and **Text** colors.
* **Action Button**: Set the **Button Color** and the specific **Button Content** (e.g., `<i class="fa-solid fa-download"></i> Download`).
* **Content Logic**: Set a **Description Limit** to ensure cards remain uniform even with varying text lengths.
* **Defaults**: Provide a **Default Image URL** to be used for any download item that lacks a featured image.

---

## ⚙️ Technical Details
* **Dependencies**: Automatically enqueues **Bootstrap 5.3.2** and **Font Awesome 6.5.2**.
* **Minimum Requirements**: WordPress with Elementor (optional for widget use).
* **Post Type**: `download_item`.
* **Taxonomy**: `download_cat`.

**Author**: D Kandekore
**Version**: 1.0
