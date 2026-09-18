'use strict';

const menuButton = document.querySelector('#menu-button');
const mainNav = document.querySelector('#main-nav');
const themeButton = document.querySelector('#theme-button');

const programList = document.querySelector('#program-list');
const programFilter = document.querySelector('#program-filter');
const programEmpty = document.querySelector('#program-empty');

const faqQuestions = document.querySelectorAll('.faq-question');

const contactForm = document.querySelector('#contact-form');
const nameInput = document.querySelector('#name');
const emailInput = document.querySelector('#email');
const messageInput = document.querySelector('#message');

const nameError = document.querySelector('#name-error');
const emailError = document.querySelector('#email-error');
const messageError = document.querySelector('#message-error');
const formSuccess = document.querySelector('#form-success');

const backToTop = document.querySelector('#back-to-top');

const programs = [
    {
        title: 'HTML & CSS Dasar',
        description: 'Pelajari struktur halaman web dan cara membuat tampilan dengan CSS.',
        category: 'web'
    },
    {
        title: 'JavaScript Dasar',
        description: 'Pelajari variabel, kondisi, perulangan, function, dan konsep dasar JavaScript.',
        category: 'programming'
    },
    {
        title: 'Project Landing Page',
        description: 'Terapkan kemampuan HTML dan CSS dengan membuat project landing page.',
        category: 'project'
    },
    {
        title: 'Dasar Programming',
        description: 'Kenali konsep logika pemrograman dan cara menyelesaikan masalah dengan kode.',
        category: 'programming'
    },
    {
        title: 'Web Project Sederhana',
        description: 'Gabungkan HTML, CSS, dan JavaScript untuk membuat website interaktif sederhana.',
        category: 'project'
    }
];

function renderPrograms(data) {
    programList.replaceChildren();

    data.forEach(function (program) {
        const card = document.createElement('article');
        card.classList.add('program-card');

        const title = document.createElement('h3');
        title.textContent = program.title;

        const description = document.createElement('p');
        description.textContent = program.description;

        const category = document.createElement('span');
        category.classList.add('program-category');
        category.textContent = getCategoryName(program.category);

        card.append(title, description, category);
        programList.appendChild(card);
    });

    programEmpty.hidden = data.length !== 0;
}

function getCategoryName(category) {
    if (category === 'web') {
        return 'Web Development';
    }

    if (category === 'programming') {
        return 'Programming';
    }

    if (category === 'project') {
        return 'Project';
    }

    return 'Program';
}

function filterPrograms() {
    const selectedCategory = programFilter.value;

    if (selectedCategory === 'semua') {
        renderPrograms(programs);
        return;
    }

    const filteredPrograms = programs.filter(function (program) {
        return program.category === selectedCategory;
    });

    renderPrograms(filteredPrograms);
}

function toggleMenu() {
    const isOpen = mainNav.classList.toggle('menu-open');

    menuButton.setAttribute('aria-expanded', String(isOpen));

    if (isOpen) {
        menuButton.setAttribute('aria-label', 'Tutup menu');
        menuButton.textContent = '✕';
    } else {
        menuButton.setAttribute('aria-label', 'Buka menu');
        menuButton.textContent = '☰';
    }
}

function closeMenu() {
    mainNav.classList.remove('menu-open');
    menuButton.setAttribute('aria-expanded', 'false');
    menuButton.setAttribute('aria-label', 'Buka menu');
    menuButton.textContent = '☰';
}

function toggleTheme() {
    document.body.classList.toggle('dark-theme');

    const darkModeActive = document.body.classList.contains('dark-theme');

    if (darkModeActive) {
        themeButton.textContent = '☀️ Tema';
    } else {
        themeButton.textContent = '🌙 Tema';
    }
}

function toggleFaq(event) {
    const button = event.currentTarget;
    const answer = button.nextElementSibling;
    const isExpanded = button.getAttribute('aria-expanded') === 'true';

    faqQuestions.forEach(function (question) {
        const otherAnswer = question.nextElementSibling;

        question.setAttribute('aria-expanded', 'false');
        otherAnswer.hidden = true;
        question.querySelector('span').textContent = '+';
    });

    if (!isExpanded) {
        button.setAttribute('aria-expanded', 'true');
        answer.hidden = false;
        button.querySelector('span').textContent = '−';
    }
}

function clearErrors() {
    nameError.textContent = '';
    emailError.textContent = '';
    messageError.textContent = '';

    nameInput.removeAttribute('aria-invalid');
    emailInput.removeAttribute('aria-invalid');
    messageInput.removeAttribute('aria-invalid');
}

function validateForm() {
    let valid = true;

    clearErrors();

    if (nameInput.value.trim().length < 2) {
        nameError.textContent = 'Nama minimal 2 karakter.';
        nameInput.setAttribute('aria-invalid', 'true');
        valid = false;
    }

    if (!emailInput.value.includes('@')) {
        emailError.textContent = 'Masukkan email yang valid.';
        emailInput.setAttribute('aria-invalid', 'true');
        valid = false;
    }

    if (messageInput.value.trim().length < 5) {
        messageError.textContent = 'Pesan minimal 5 karakter.';
        messageInput.setAttribute('aria-invalid', 'true');
        valid = false;
    }

    return valid;
}

function handleFormSubmit(event) {
    event.preventDefault();

    formSuccess.hidden = true;

    const valid = validateForm();

    if (!valid) {
        return;
    }

    formSuccess.hidden = false;
    contactForm.reset();
    clearErrors();
}

function handleBackToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}

menuButton.addEventListener('click', toggleMenu);

programFilter.addEventListener('change', filterPrograms);

themeButton.addEventListener('click', toggleTheme);

faqQuestions.forEach(function (question) {
    question.addEventListener('click', toggleFaq);
});

contactForm.addEventListener('submit', handleFormSubmit);

backToTop.addEventListener('click', handleBackToTop);

mainNav.querySelectorAll('a').forEach(function (link) {
    link.addEventListener('click', closeMenu);
});

renderPrograms(programs);