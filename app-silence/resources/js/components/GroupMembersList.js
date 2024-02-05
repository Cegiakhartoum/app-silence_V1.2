import React from 'react';
import ReactDOM from 'react-dom';

window.renderStudentsCreate = () => {
    ReactDOM.render(<GroupMembersList suffix="create" />, document.getElementById('create-students'));
}

window.renderStudentsEdit = (callback) => {
    ReactDOM.render(<GroupMembersList suffix="update" />, document.getElementById('edit-students'), callback);
}

function GroupMember(member, suffix) {

    const inputId = "btn-check-edit-" + suffix + "-" + member.id;
    const key = suffix + "-" + member.id;

    return (
        <div key={key} className="d-flex align-content-stretch">
            <input type="checkbox" className="btn-check student-button"
                id={inputId} autoComplete="off"
                value={member.id} />
            <label className="btn btn-outline-primary student-button-label"
                htmlFor={inputId}>{member.name}</label>
        </div>
    );
}

function GroupMembersList(props) {

    const students_items = available_students.map((student) => GroupMember(student, props.suffix));

    return (
        <div>
            {students_items}
        </div>
    );

}

export default GroupMembersList;

// if (document.getElementById('students')) {
//     ReactDOM.render(<GroupMembersList />, document.getElementById('students'));
// }
