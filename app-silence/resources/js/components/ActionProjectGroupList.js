import React from 'react';
import ReactDOM from 'react-dom';

window.createdGroup = () => {

    const members_ids = $("#createGroupModal .student-button:checked").map(function () {
        return parseInt($(this).val());
    }).toArray();

    const std = students.filter(s => members_ids.includes(s.id));

    var group = {
        id: Date.now(),
        name: "",
        members: std
    };

    groups.push(group);

    closeCreateGroupModal();
    updateGroupsUI();
}

window.updateGroup = () => {

    const group = groups.find(el => el.id == updatingGroupId);

    const members_ids = $("#editGroupModal .student-button:checked").map(function () {
        return $(this).val();
    }).toArray();

    const std = students.filter(s => members_ids.includes(s.id));
    group.members = std;

    closeEditGroupModal();
    updateGroupsUI();
}

window.updateGroupsUI = () => {
    ReactDOM.render(<ActionProjectGroupList />, document.getElementById('action-groups'));
}

function updateGroupName(event, id) {
    groups.find(el => el.id == id).name = event.target.value;
    updateGroupsUI();
}

function editGroupMembers(id) {
    updatingGroupId = id;
    const group = groups.find(el => el.id == id);
    openEditGroupModal(group.members);
}

function deleteGroup(id) {
    groups = groups.filter(el => el.id != id);
    updateGroupsUI();
}


export function ActionProjectGroup(group) {
    return (
        <div key={group.id} className="d-flex align-items-end group-container">
            <div>
                <button type="button" className="btn btn-danger" onClick={e => deleteGroup(group.id)}>
                    <i className="fas fa-trash"></i>
                </button>
            </div>
            <span className="group_separator"></span>
            <div className="flex-even">
                <div>
                    <label className="text-white" >Nom du groupe :</label>
                    <input type="text" className="form-control text-orange" id="nameInput" name="nom"
                        value={group.name} onChange={e => updateGroupName(e, group.id)} />
                </div>
            </div>
            <span className="group_separator"></span>
            <div className="flex-even">
                <div>
                    <label className="text-white">Les élèves :</label>
                    <input type="text" className="form-control text-black" id="nameInput" name="nom"
                        value={group.members.map(m => m.name).join(" , ")} readOnly={true} onClick={e => editGroupMembers(group.id)} />
                </div>
            </div>
        </div>
    );
}

function ActionProjectGroupList() {

    const groups_items = groups.map((group) => ActionProjectGroup(group));
    return (
        <div>
            {groups_items}
        </div>
    );

}

export default ActionProjectGroupList;

if (document.getElementById('action-groups')) {
    ReactDOM.render(<ActionProjectGroupList />, document.getElementById('action-groups'));
}
