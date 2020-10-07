import React from 'react';
import NumberFormat from 'react-number-format';

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
                <div className="col-5">
                    <span style={{ fontSize: 18 }}>{sponsor.user.name}</span>
                    <br />
                    <span style={{ fontSize: 15 }}>{sponsor.user.email}<br />{sponsor.user.profile.phone_no}</span>
                </div>
                <div className="col-4 pt-1 align-text-right">
                    <span style={{ fontSize: 15 }}>
                        {sponsor.units} <strong>Unit{sponsor.units > 1 ? 's' : null}</strong>
                        &nbsp;(
                        &#8358;
                        <NumberFormat
                            value={sponsor.total_capital}
                            displayType={'text'}
                            thousandSeparator={true}
                            decimalScale={2}
                            fixedDecimalScale={true}
                        />)</span>
                    {sponsor.has_received_returns ?
                        <React.Fragment>
                            <br />
                            <span style={{ fontSize: 15 }}>
                                <span className="fa fa-check-circle green-ic mr-2"></span>
                                &#8358;
                            <NumberFormat
                                    value={sponsor.actual_returns_received}
                                    displayType={'text'}
                                    thousandSeparator={true}
                                    decimalScale={2}
                                    fixedDecimalScale={true}
                                />
                                &nbsp;<small className="grey-text bold">(
                                    <NumberFormat
                                        value={sponsor.received_returns_pct * 100}
                                        displayType={'text'}
                                        thousandSeparator={true}
                                        decimalScale={1}
                                        fixedDecimalScale={true}
                                        suffix={"%"}
                                    />
                                    )
                                </small>
                            </span>
                        </React.Fragment> : null}
                </div>
            </div>
        </li>
    );
}