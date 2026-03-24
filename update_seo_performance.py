import os
import glob
import re

directory = r"e:\wamp\www\blog"
php_files = glob.glob(os.path.join(directory, "*.php"))

for filepath in php_files:
    try:
        with open(filepath, 'r', encoding='utf-8') as f:
            content = f.read()
            
        modified = False
        
        # 1. Bypass minify_html
        if "function minify_html($buffer) {\n      $search = array(" in content:
            content = content.replace("function minify_html($buffer) {\n      $search = array(", "function minify_html($buffer) { return $buffer;\n      $search = array(")
            modified = True
        elif "function minify_html($buffer) {" in content and "return $buffer;" not in content:
            content = content.replace("function minify_html($buffer) {", "function minify_html($buffer) { return $buffer;")
            modified = True

        # 2. Fix Canonical and OG domains to malithatishamal.42web.io
        new_content = re.sub(r'https://(?:www\.)?(?:edulk|mediq|eduwide|malithatishamal)\.42web\.io', 'https://malithatishamal.42web.io', content)
        if new_content != content:
            content = new_content
            modified = True
            
        # 3. Add preload for CSS if not present
        preload_tag = '<link rel="preload" href="assets/css/bundle.min.css" as="style">'
        stylesheet_tag = '<link href="assets/css/bundle.min.css" rel="stylesheet">'
        if preload_tag not in content and stylesheet_tag in content:
            content = content.replace(stylesheet_tag, f"{preload_tag}\n  {stylesheet_tag}")
            modified = True
            
        if modified:
            with open(filepath, 'w', encoding='utf-8') as f:
                f.write(content)
            print(f"Updated {os.path.basename(filepath)}")
            
    except Exception as e:
        print(f"Error processing {os.path.basename(filepath)}: {e}")

# 4. Defer bundle.min.js in footer.php
footer_path = os.path.join(directory, 'includes', 'footer.php')
try:
    with open(footer_path, 'r', encoding='utf-8') as f:
        footer_content = f.read()

    new_footer = footer_content.replace('<script src="assets/js/bundle.min.js"></script>', '<script src="assets/js/bundle.min.js" defer></script>')
    if new_footer != footer_content:
        with open(footer_path, 'w', encoding='utf-8') as f:
            f.write(new_footer)
        print("Updated footer.php with defer.")
except Exception as e:
    print(f"Error updating footer: {e}")

print("All updates processed.")
