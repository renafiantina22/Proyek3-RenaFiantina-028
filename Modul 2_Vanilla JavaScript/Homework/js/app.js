const statusEl = document.querySelector("#status");
const profileEl = document.querySelector("#profile");
const detailEl = document.querySelector("#detail");
const skillsEl = document.querySelector("#skills");

const btnDetail = document.querySelector("#btnDetail");
const btnTema = document.querySelector("#btnTema");
const btnRetry = document.querySelector("#btnRetry");

const skillSection = document.querySelector("#skillSection");

const skillForm = document.querySelector("#skillForm");
const skillInput = document.querySelector("#skillInput");
const formMessage = document.querySelector("#formMessage");

let profileData = null;
let sedangMemuat = false;


function setState(state, message) {
    statusEl.className = "status";
    statusEl.classList.add(state);
    statusEl.textContent = message;
}


async function ambilProfile() {
    const response = await fetch("data/profile.json");
    if (!response.ok) {
        throw new Error(
            `Gagal mengambil data. Status HTTP: ${response.status}`
        );
    }
    const data = await response.json();
    return data;
}


function renderProfile(data) {
    profileEl.replaceChildren();
    const nama = document.createElement("h2");
    nama.className = "profile-name";
    nama.textContent = data.nama;

    const deskripsi = document.createElement("p");
    deskripsi.className = "profile-description";
    deskripsi.textContent = data.deskripsi;
    profileEl.append(nama, deskripsi);
}


function renderDetail(data) {
    detailEl.replaceChildren();
    const title = document.createElement("h3");
    title.className = "detail-title";
    title.textContent = "Detail Profil";

    const text = document.createElement("p");
    text.className = "detail-text";
    text.textContent = data.detail;
    detailEl.append(title, text);
}


function renderSkills() {
    skillsEl.replaceChildren();
    if (profileData.skills.length === 0) {
        const emptyMessage = document.createElement("p");
        emptyMessage.textContent =
            "Belum ada keterampilan.";
        skillsEl.append(emptyMessage);
        return;
    }

    profileData.skills.forEach((skill, index) => {
        const item = document.createElement("div");
        item.className = "skill-item";

        const skillName = document.createElement("span");
        skillName.className = "skill-name";
        skillName.textContent = skill;

        const deleteButton = document.createElement("button");
        deleteButton.type = "button";
        deleteButton.className = "delete-button";
        deleteButton.textContent = "Hapus";
        deleteButton.addEventListener("click", () => {
            profileData.skills.splice(index, 1);
            renderSkills();
            updateSkillStatus();
        });


        item.append(skillName, deleteButton);
        skillsEl.append(item);
    });

}

function updateSkillStatus() {
    if (profileData.skills.length === 0) {
        setState(
            "empty",
            "Profil tersedia, tetapi belum ada keterampilan."
        );
    } else {
        setState(
            "success",
            `${profileData.skills.length} keterampilan tersedia.`
        );
    }

}

async function muatData() {
    if (sedangMemuat) {
        return;
    }
    sedangMemuat = true;
    btnRetry.hidden = true;
    btnDetail.hidden = true;
    btnTema.hidden = true;
    skillSection.hidden = true;

    setState(
        "loading",
        "Memuat data profil..."
    );

    try {
        const data = await ambilProfile();
        if (!data || !Array.isArray(data.skills)) {
            throw new Error(
                "Format data profile.json tidak valid."
            );
        }

        profileData = data;
        renderProfile(profileData);
        renderDetail(profileData);
        renderSkills();

        btnDetail.hidden = false;
        btnTema.hidden = false;
        skillSection.hidden = false;
 
        detailEl.hidden = true;
        btnDetail.setAttribute(
            "aria-expanded",
            "false"
        );

        updateSkillStatus();

    } catch (error) {
        console.error(
            "Terjadi error:",
            error
        );


        profileEl.replaceChildren();
        detailEl.replaceChildren();
        skillsEl.replaceChildren();

        skillSection.hidden = true;
        btnDetail.hidden = true;
        btnTema.hidden = true;

        setState(
            "error",
            `Terjadi kesalahan: ${error.message}`
        );

        btnRetry.hidden = false;
    } finally {
        sedangMemuat = false;
    }
}


btnDetail.addEventListener(
    "click",
    () => {
        detailEl.hidden =
            !detailEl.hidden;

        detailEl.classList.toggle(
            "is-open"
        );

        const sedangTerbuka =
            !detailEl.hidden;

        btnDetail.setAttribute(
            "aria-expanded",
            String(sedangTerbuka)
        );

        btnDetail.textContent =
            sedangTerbuka
                ? "Tutup detail"
                : "Lihat detail";
    }
);

btnTema.addEventListener(
    "click",
    () => {
        document.body.classList.toggle(
            "dark"
        );

    }
);

skillForm.addEventListener(
    "submit",
    (event) => {
        event.preventDefault();

        const skill =
            skillInput.value.trim();

        formMessage.textContent = "";

        if (skill === "") {
            formMessage.textContent =
                "Keterampilan tidak boleh kosong.";
            skillInput.focus();
            return;
        }

        profileData.skills.push(skill);

        skillInput.value = "";

        formMessage.textContent =
            "Keterampilan berhasil ditambahkan.";

        renderSkills();
        updateSkillStatus();
    }
);

btnRetry.addEventListener(
    "click",
    () => { 
        muatData();
    }
);

muatData();