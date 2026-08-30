const NCBIIMock = (() => {
    const seed = {
        students: [
            { id: '2026-0001', firstName: 'Maria', lastName: 'Santos', email: 'maria.santos@ncbii.edu', status: 'Active' },
            { id: '2026-0002', firstName: 'John', lastName: 'Reyes', email: 'john.reyes@ncbii.edu', status: 'Active' },
            { id: '2026-0003', firstName: 'Angela', lastName: 'Cruz', email: 'angela.cruz@ncbii.edu', status: 'Active' },
            { id: '2026-0004', firstName: 'Pedro', lastName: 'Santos', email: 'pedro.santos@ncbii.edu', status: 'Active' },
            { id: '2026-0005', firstName: 'Ana', lastName: 'Reyes', email: 'ana.reyes@ncbii.edu', status: 'Active' },
            { id: '2026-0006', firstName: 'Luis', lastName: 'Garcia', email: 'luis.garcia@ncbii.edu', status: 'Active' }
        ],
        faculty: [
            { id: 'FAC-001', name: 'Prof. Daniel Cruz', email: 'daniel.cruz@ncbii.edu', status: 'Teaching' },
            { id: 'FAC-002', name: 'Prof. Ana Lim', email: 'ana.lim@ncbii.edu', status: 'Teaching' },
            { id: 'FAC-003', name: 'Prof. Rosa Velasco', email: 'rosa.velasco@ncbii.edu', status: 'On leave' }
        ],
        instructorAssignments: [
            { instructorId: 'FAC-001', subjectCodes: ['IT101'] },
            { instructorId: 'FAC-002', subjectCodes: ['IT102'] },
            { instructorId: 'FAC-003', subjectCodes: ['IT103'] }
        ],
        subjects: [
            { code: 'IT101', name: 'Introduction to Information Technology', units: 3, prerequisite: 'None' },
            { code: 'IT102', name: 'Programming 1', units: 3, prerequisite: 'IT101' },
            { code: 'IT103', name: 'Database Fundamentals', units: 3, prerequisite: 'IT101' }
        ],
        classes: [
            { id: 'CLASS-001', code: 'IT101', subject: 'Introduction to Information Technology', faculty: 'Prof. Daniel Cruz', day: 'Monday', time: '8:00 AM - 10:00 AM', room: 'Room 101', schoolYear: '2026-2027', semester: '1st Semester' },
            { id: 'CLASS-002', code: 'IT102', subject: 'Programming 1', faculty: 'Prof. Ana Lim', day: 'Tuesday', time: '10:00 AM - 12:00 PM', room: 'Room 102', schoolYear: '2026-2027', semester: '1st Semester' },
            { id: 'CLASS-003', code: 'IT103', subject: 'Database Fundamentals', faculty: 'Prof. Rosa Velasco', day: 'Wednesday', time: '1:00 PM - 3:00 PM', room: 'Laboratory 1', schoolYear: '2026-2027', semester: '1st Semester' }
        ],
        subjectLoad: [
            { id: 'LOAD-001', studentId: '2026-0001', classId: 'CLASS-001' },
            { id: 'LOAD-002', studentId: '2026-0001', classId: 'CLASS-002' },
            { id: 'LOAD-003', studentId: '2026-0001', classId: 'CLASS-003' },
            { id: 'LOAD-004', studentId: '2026-0004', classId: 'CLASS-001' },
            { id: 'LOAD-005', studentId: '2026-0005', classId: 'CLASS-002' },
            { id: 'LOAD-006', studentId: '2026-0006', classId: 'CLASS-003' }
        ],
        grades: [
            { id: 'GRADE-001', studentId: '2026-0001', classId: 'CLASS-001', prelim: 1.75, midterm: 1.5, final: 1.25 },
            { id: 'GRADE-002', studentId: '2026-0001', classId: 'CLASS-002', prelim: 2, midterm: 1.75, final: 1.5 },
            { id: 'GRADE-003', studentId: '2026-0001', classId: 'CLASS-003', prelim: 1.5, midterm: 1.25, final: 1 },
            { id: 'GRADE-004', studentId: '2026-0004', classId: 'CLASS-001', prelim: 2.25, midterm: 2, final: 1.75 },
            { id: 'GRADE-005', studentId: '2026-0005', classId: 'CLASS-002', prelim: 'INC', midterm: 'INC', final: 'INC' },
            { id: 'GRADE-006', studentId: '2026-0006', classId: 'CLASS-003', prelim: 'NG', midterm: 'NG', final: 'NG' }
        ]
    };
    const key = 'ncbiiMockData';
    const data = JSON.parse(sessionStorage.getItem(key) || 'null') || seed;
    if (!data.instructorAssignments || data.instructorAssignments.length !== seed.instructorAssignments.length) data.instructorAssignments = seed.instructorAssignments;
    seed.classes.forEach((seedClass) => { const storedClass = data.classes.find((item) => item.id === seedClass.id); if (storedClass) storedClass.faculty = seedClass.faculty; });
    if (!data.students.some((student) => student.id === '2026-0004')) data.students.push(...seed.students.slice(3));
    if (!data.subjectLoad.some((load) => load.id === 'LOAD-004')) data.subjectLoad.push(...seed.subjectLoad.slice(3));
    if (!data.grades.some((grade) => grade.id === 'GRADE-004')) data.grades.push(...seed.grades.slice(3));
    function save() { sessionStorage.setItem(key, JSON.stringify(data)); }
    function remove(collection, id) { data[collection] = data[collection].filter((item) => item.id !== id); save(); }
    function studentName(student) { return `${student.firstName} ${student.lastName}`; }
    function getStudent(id) { return data.students.find((student) => student.id === id); }
    function getClass(id) { return data.classes.find((item) => item.id === id); }
    function getFaculty(id) { return data.faculty.find((item) => item.id === id); }
    function isInstructorAuthorized(instructorId, subjectCode) { const assignment = data.instructorAssignments.find((item) => item.instructorId === instructorId); return Boolean(assignment && assignment.subjectCodes.includes(subjectCode)); }
    function getAssignedClasses(instructorId) { const assignment = data.instructorAssignments.find((item) => item.instructorId === instructorId); return data.classes.filter((item) => assignment && assignment.subjectCodes.includes(item.code)); }
    function getClassStudents(classId) { const studentIds = data.subjectLoad.filter((load) => load.classId === classId).map((load) => load.studentId); return data.grades.filter((grade) => grade.classId === classId).map((grade) => ({ ...grade, student: getStudent(grade.studentId) })).filter((grade) => studentIds.includes(grade.studentId)); }
    function getStudentLoad(id) { return data.subjectLoad.filter((load) => load.studentId === id).map((load) => ({ ...load, student: getStudent(load.studentId), classRecord: getClass(load.classId) })); }
    function getStudentGrades(id) { return data.grades.filter((grade) => grade.studentId === id).map((grade) => ({ ...grade, student: getStudent(grade.studentId), classRecord: getClass(grade.classId) })); }
    function getStudentGeneralAverage(id) { const grades = getStudentGrades(id).flatMap((grade) => [grade.prelim, grade.midterm, grade.final]).map((grade) => Number(grade)).filter((grade) => Number.isFinite(grade) && grade >= 1 && grade <= 5); return grades.length ? (grades.reduce((total, grade) => total + grade, 0) / grades.length).toFixed(2) : 'N/A'; }
    function getSemestralGrade(grade) { const terms = [grade.prelim, grade.midterm, grade.final].map((value) => String(value ?? '').trim().toUpperCase()); if (terms.includes('INC')) return 'INC'; if (terms.includes('NG')) return 'NG'; const numericGrades = terms.map(Number).filter((value) => Number.isFinite(value) && value >= 1 && value <= 5); return numericGrades.length === 3 ? (numericGrades.reduce((total, value) => total + value, 0) / 3).toFixed(2) : 'N/A'; }
    function getGradeRemark(value) { const grade = String(value ?? '').trim().toUpperCase(); if (grade === 'INC') return 'INC'; if (grade === 'NG') return 'NG'; if (!/^(?:[1-5](?:\.\d{1,2})?)$/.test(grade)) return 'NO GRADE'; return Number(grade) <= 3 ? 'PASSED' : 'FAILED'; }
    function updateStudentGradeTable() { const table = document.querySelector('.directory-table'); if (!table || !location.pathname.endsWith('student-records.html') || new URLSearchParams(location.search).get('view') !== 'grades') return; const headers = table.querySelectorAll('thead th'); if (headers[3] && headers[3].textContent !== 'Final Grade') headers[3].textContent = 'Final Grade'; table.querySelectorAll('tbody tr').forEach((row) => { const cells = row.querySelectorAll('td'); const finalGrade = cells[3]?.textContent; const remark = getGradeRemark(finalGrade); const remarkCell = cells[4]; if (remarkCell && remarkCell.textContent.trim() !== remark) remarkCell.innerHTML = `<b class="grade ${remark === 'PASSED' ? 'good' : 'pending'}">${remark}</b>`; }); }
    function timeStart(time) { return Number((time.match(/(\d+):?(\d*)/) || [0, 0])[1]); }
    function conflicts(candidate) { return data.classes.some((item) => item.id !== candidate.id && item.day === candidate.day && item.time === candidate.time && (item.faculty === candidate.faculty || item.room === candidate.room)); }
    if (typeof document !== 'undefined') new MutationObserver(updateStudentGradeTable).observe(document.body, { childList: true, subtree: true });
    return { data, save, remove, studentName, getStudent, getClass, getFaculty, isInstructorAuthorized, getAssignedClasses, getClassStudents, getStudentLoad, getStudentGrades, getStudentGeneralAverage, getSemestralGrade, getGradeRemark, conflicts, timeStart };
})();
