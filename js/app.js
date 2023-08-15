// https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Roles/link_role

const fakeLinks = document.querySelectorAll('[role="link"]')

for (let i = 0; i < fakeLinks.length; i++) {
   fakeLinks[i].addEventListener("click", navigateLink)
   fakeLinks[i].addEventListener("keydown", navigateLink)
}

//handles clicks and keydowns on the link
function navigateLink(e) {
   if (e.type === "click" || e.key === "Enter") {
      const ref = e.target.closest('[role="link"]')
      if (ref) {
         window.open(ref.getAttribute("data-href"), '_self')
         // location.href = ref.getAttribute("data-href")
         console.log(ref.getAttribute("data-href"))
      }
   }
}
