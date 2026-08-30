(() => {
    function text(element, value) {
        if (element) element.textContent = value;
    }

    function renderStudent() {
        const root = document.querySelector('[data-portal="student"]');
        if (!root || typeof NCBIIMock === 'undefined') return;

        const studentId = root.dataset.studentId;
        const student = NCBIIMock.getStudent(studentId) || NCBIIMock.data.students[0];
        const load = NCBIIMock.getStudentLoad(student.id);
        const grades = NCBIIMock.getStudentGrades(student.id);
        const units = load.reduce((total, item) => {
            const subject = NCBIIMock.data.subjects.find((record) => record.code === item.classRecord?.code);
            return total + Number(subject?.units || 0);
        }, 0);

        text(root.querySelector('[data-student-name]'), NCBIIMock.studentName(student));
        text(root.querySelector('[data-subject-count]'), `${load.length} Subjects`);
        text(root.querySelector('[data-subject-units]'), `${units} units this semester`);
        text(root.querySelector('[data-general-average]'), NCBIIMock.getStudentGeneralAverage(student.id));

        const schedule = root.querySelector('[data-schedule-content]');
        if (schedule) {
            schedule.replaceChildren(...load.map((item) => {
                const paragraph = document.createElement('p');
                const record = item.classRecord;
                paragraph.textContent = `${record.day}, ${record.time} - ${record.subject} | ${record.room}`;
                return paragraph;
            }));
        }

        grades.forEach((grade) => {
            grade.semestral = NCBIIMock.getSemestralGrade(grade);
        });
    }

    function renderFaculty() {
        const root = document.querySelector('[data-portal="faculty"]');
        const target = root?.querySelector('[data-assigned-subjects]');
        if (!root || !target || typeof NCBIIMock === 'undefined') return;

        const classes = NCBIIMock.getAssignedClasses(root.dataset.facultyId);
        target.replaceChildren(...classes.map((record) => {
            const card = document.createElement('a');
            card.className = 'subject-card credited';
            card.href = `${root.closest('main').dataset.facultyUrl || '/faculty'}?subject=${encodeURIComponent(record.code)}`;
            card.innerHTML = `<div><span class="subject-status">CREDITED SUBJECT</span><h3></h3><p></p></div><span class="subject-card-link">View student list</span>`;
            text(card.querySelector('h3'), record.subject);
            text(card.querySelector('p'), `${record.code} · ${NCBIIMock.getClassStudents(record.id).length} students`);
            return card;
        }));
    }

    function renderAdmin() {
        const root = document.querySelector('[data-portal="admin"]');
        if (!root || typeof NCBIIMock === 'undefined') return;
        Object.entries({
            students: NCBIIMock.data.students.length,
            subjects: NCBIIMock.data.subjects.length,
            subjectLoad: NCBIIMock.data.subjectLoad.length
        }).forEach(([key, count]) => text(root.querySelector(`[data-admin-count="${key}"]`), count));
    }

    function bindLogin() {
        const select = document.querySelector('#access_type');
        const studentFields = document.querySelector('#studentFields');
        const staffFields = document.querySelector('#staffFields');
        const tabs = document.querySelectorAll('[data-access]');
        if (!select || !studentFields || !staffFields || !tabs.length) return;
        const update = (value) => {
            select.value = value;
            const student = value === 'student';
            studentFields.hidden = !student;
            staffFields.hidden = student;
            tabs.forEach((tab) => {
                const active = tab.dataset.access === value;
                tab.classList.toggle('active', active);
                tab.setAttribute('aria-selected', String(active));
            });
        };
        tabs.forEach((tab) => tab.addEventListener('click', () => update(tab.dataset.access)));
        update(select.value || 'student');
    }

    document.addEventListener('DOMContentLoaded', () => {
        renderStudent();
        renderFaculty();
        renderAdmin();
        bindLogin();
    });
})();
