const form = document.getElementById('create-form');

form.addEventListener('submit', async e => {
  e.preventDefault();
  
  const sections = Array.from(document.querySelectorAll('textarea[name="sections[]"]'))
                        .map(t => t.value);

  const res = await fetch('/create-post', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      title: form.title.value,
      category: form.category.value,
      sections: JSON.stringify(sections)
    })
  });

  const data = await res.json();
  alert(data.message);
});

function addSection() {
  const container = document.querySelector('.sections');
  if (container.querySelectorAll('textarea').length >= 3) return;

  const textarea = document.createElement('textarea');
  textarea.name = 'sections[]';
  container.appendChild(textarea);
}