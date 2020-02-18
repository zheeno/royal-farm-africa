import React, { Component } from 'react';

export const SponsorListItem = props => {
    let sponsor = props.sponsor;
    return (
        <li className="list-group-item">
            <div className="row">
                <div className="col-1">
                    {/* {!props.sponsor.has_received_returns ? */}
                    <button className="btn m-0 shadow-none" disabled={sponsor.has_received_returns} onClick={() => props.toggleChecker(sponsor.id)}><span className={props.checkIfPresent(sponsor.id) ? "fa fa-check-square fa-2x" : "fa fa-2x fa-square-o"}></span></button>
                    {/* : null} */}
                </div>
                <div className="col-2">
                    <img className="img-responsive btn-sm-rounded grey lighten-3" src={sponsor.user.profile.avatar_url} />
                </div>
                <div className="col-6">
                    <span style={{ fontSize: 18 }}>{sponsor.user.name}</span>
                    <br />
                    <span style={{ fontSize: 15 }}>{sponsor.user.email}<br />{sponsor.user.profile.phone_no}</span>
                </div>
                <div className="col-3 pt-1 align-text-right">
                    <span style={{ fontSize: 16 }}>{sponsor.units} Unit{sponsor.units > 1 ? 's' : null}</span>
                    {sponsor.has_received_returns ?
                        <React.Fragment>
                            <br /><span className="badge badge-success">Returns Received</span>
                        </React.Fragment> : null}
                </div>
            </div>
        </li>
    );
}