// check for password match
const form = document.getElementById('form')
const password1 = document.getElementById('password1')
const password2 = document.getElementById('password2')

form.addEventListener('submit', (e) => {
   e.preventDefault()

   if (password1.value != password2.value) {
      password2.setCustomValidity('Passwords do not match!')
      password2.reportValidity()
      return
   } else {
      password2.setCustomValidity('')
   }

   form.submit()
})