from playwright.sync_api import sync_playwright
import os

def run():
    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)

        # Mobile
        page = browser.new_page(viewport={'width': 375, 'height': 812})
        # Use file:// protocol
        file_path = os.path.abspath("verification/test.html")
        page.goto(f"file://{file_path}")
        page.screenshot(path="verification/mobile.png")
        print("Mobile screenshot taken.")
        page.close()

        browser.close()

if __name__ == "__main__":
    run()
