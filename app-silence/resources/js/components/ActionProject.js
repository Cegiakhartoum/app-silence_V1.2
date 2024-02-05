import React from 'react';
import ReactDOM from 'react-dom';


function ActionProject() {

    return (
        <div className="container">
            <div className="row justify-content-center">
                <div className="col-md-8">
                    <div className="card">
                        <div className="card-header">ActionProject Component</div>
                        <div className="card-body">
                            I'm an ActionProject component!
                            <button onClick={activateLasers}>
                                Activate Lasers
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default ActionProject;

if (document.getElementById('action-project')) {
    ReactDOM.render(<ActionProject />, document.getElementById('action-project'));
}
