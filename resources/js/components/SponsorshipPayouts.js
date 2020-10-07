import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import Axios from 'axios';
import { SponsorListItem } from './MiscComponents';


export default class SponsorshipPayouts extends Component {
    constructor(props) {
        super(props);
        this.state = {
            selectAll: false,
            isPaying: false,
            showConfirmation: false,
            selectedSponsors: [],
            sponId: this.props.sponId,
            sponsors: [],
            sponsorship: null,
            isLoading: true,
            requestSuccess: false,
            error: null,
            exp_ret_pct: null,
        }
        this.initComponent = this.initComponent.bind(this);
        this.selectAll = this.selectAll.bind(this);
        this.payoutSelected = this.payoutSelected.bind(this);
        this.handleCustomEstEntry = this.handleCustomEstEntry.bind(this);
    }

    componentDidMount() {
        this.initComponent();
    }


    handleCustomEstEntry(e) {
        const val = e.target["value"];
        if (val != null) {
            this.setState({ exp_ret_pct: val });
        }
    }

    selectAll() {
        this.setState({ selectAll: !this.state.selectAll, selectedSponsors: [] });
        if (!this.state.selectAll) {
            // populate the selectedSponsors array
            let arr = [];
            this.state.sponsors.forEach(sponsor => {
                if (!sponsor.has_received_returns) {
                    arr.push(sponsor.id);
                }
            });
            this.setState({ selectedSponsors: arr });
        }
    }

    payoutSelected(useDefault) {
        if (this.state.selectedSponsors.length > 0) {
            this.setState({ isPaying: true });
            let params = "";
            if (!useDefault) {
                params = "&exp_ret_pct=" + this.state.exp_ret_pct;
            }

            Axios.get("/cms/sponsorsPayoutInitiate?spon_id=" + this.state.sponsorship.id + "&useDefault=" + useDefault + "&sponsors=" + this.state.selectedSponsors.toString() + params).then(
                response => {
                    const data = response.data;
                    console.log("SPON PAYOUT", data);
                    this.setState({
                        isPaying: false,
                        requestSuccess: true,
                        selectedSponsors: [],
                        selectAll: false,
                        showConfirmation: false,
                        sponsors: data.sponsors_data.sponsors,
                        sponsorship: data.sponsorship,
                        error: null,
                        exp_ret_pct: null,
                    });
                }
            ).catch(errors => {
                this.setState({
                    isPaying: false,
                    sponsors: [],
                    sponsorship: null,
                    error: errors.message,
                    requestSuccess: false,
                    exp_ret_pct: null,
                });
                alert(errors.message);
                console.log(errors);
            });
        }
    }

    initComponent() {
        this.setState({ isLoading: true });
        Axios.get('/cms/getSponsorshipPayoutsData?spon_id=' + this.state.sponId).then(
            response => {
                const data = response.data;
                this.setState({
                    isLoading: false,
                    requestSuccess: true,
                    sponsors: data.sponsors_data.sponsors,
                    sponsorship: data.sponsorship,
                    error: null,
                });
            }
        ).catch(errors => {
            this.setState({
                isLoading: false,
                sponsors: [],
                sponsorship: null,
                error: errors.message,
                requestSuccess: false
            });
            alert(errors.message);
            console.log(errors);
        });
    }

    render() {
        return (
            <React.Fragment>
                {this.state.isLoading ? null :
                    <div className="container-fluid mb-5">
                        <div className="row mb-3">
                            <div className="navbar col-12 green darken-3">
                                <h3 className="h3-responsive white-text">Sponsorship Payouts</h3>
                            </div>
                        </div>
                        {this.state.sponsors.length == 0 ?
                            // no sponsors
                            <div className="row">
                                <div className="col-12 has-background NORESULT"></div>
                                <div className="col-12 align-text-center">
                                    <h4 className="h4-responsive">No sponsors found</h4>
                                </div>
                            </div>
                            :
                            <div className="row">
                                <div className="col-12">
                                    {this.state.sponsorship.is_completed ?
                                        this.state.showConfirmation ?
                                            <div className="py-3 px-4 align-text-center">
                                                <h4 className="h4-responnsive">Kindly confirm payout amount</h4>
                                                <h5 className="h5-responsive">Would you like to pay the estimated returns to the selected sponsors?</h5>
                                                <button className="btn green darken-3" disabled={this.state.isPaying} onClick={() => this.payoutSelected(true)}><span className="white-text">{this.state.isPaying ? "Please wait..." : "Pay " + Math.round(this.state.sponsorship.expected_returns_pct * 100) + "% for each sponsored unit"}</span></button>
                                                <button className="btn grey lighten-3" onClick={() => this.setState({ showConfirmation: false })}>Cancel</button>
                                                <h3 className="h3-responsive">OR</h3>
                                                <h5 className="h5-responsive">Would you like to pay a custom estimated percentage return to the selected sponsors?</h5>
                                                <div className="row">
                                                    <div className="col-md-4 mx-auto p-0 input-group">
                                                        <input type="number" className="form-control" placeholder="34.35" value={this.state.exp_ret_pct} onChange={this.handleCustomEstEntry} />
                                                        <div className="input-group-append">
                                                            <span className="input-group-text" id="basic-addon1">% per unit</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                {parseFloat(this.state.exp_ret_pct) > 0 && parseFloat(this.state.exp_ret_pct) <= 100 ?
                                                    <div className="row">
                                                        <div className="col-12 align-text-center">
                                                            <button className="btn green darken-3" disabled={this.state.isPaying} onClick={() => this.payoutSelected(false)}><span className="white-text">{this.state.isPaying ? "Please wait..." : "Pay " + parseFloat(this.state.exp_ret_pct) + "% for each sponsored unit"}</span></button>
                                                        </div>
                                                    </div>
                                                    : null}
                                            </div>
                                            :
                                            <React.Fragment>
                                                <div className="navbar grey lighten-2 p-1">
                                                    <button className="btn p-3 m-0 shadow-none" onClick={() => this.selectAll()} ><span className={this.state.selectedSponsors.length == this.state.sponsors.length ? "fa fa-check-square fa-2x" : "fa fa-2x fa-square-o"}></span></button>
                                                    {this.state.selectedSponsors.length > 0 ?
                                                        <button onClick={() => this.setState({ showConfirmation: true })} className="btn grey darken-1 m-0 shadow-none" ><span className="white-text">Payout Selected</span></button>
                                                        : null}
                                                </div>

                                                <ul className="list-group">
                                                    {this.state.sponsors.map((sponsor, i) => {
                                                        return (
                                                            <SponsorListItem
                                                                key={i}
                                                                sponsor={sponsor}
                                                                state={this.state}
                                                                checkIfPresent={(id) => {
                                                                    return this.state.selectedSponsors.includes(id)
                                                                }}
                                                                toggleChecker={(id) => {
                                                                    // check if the id is found within the array,
                                                                    // if so, remove it from the array,
                                                                    // else add it to the array
                                                                    const index = this.state.selectedSponsors.indexOf(id);
                                                                    if (index < 0) {
                                                                        // item not in the array, add it
                                                                        this.setState({ selectedSponsors: this.state.selectedSponsors.concat(id) })
                                                                    } else {
                                                                        let temp = [];
                                                                        this.state.selectedSponsors.forEach(spon_id => {
                                                                            if (spon_id != id) {
                                                                                temp.push(spon_id);
                                                                            }
                                                                        });
                                                                        this.setState({ selectedSponsors: temp });
                                                                    }
                                                                }}
                                                            />
                                                        )
                                                    })}
                                                </ul>
                                            </React.Fragment>
                                        : <div className="alert alert-danger">
                                            <span>Payouts can not be performed until sponsorship is completed.</span>
                                        </div>
                                    }
                                </div>
                            </div>
                        }
                    </div>
                }
            </React.Fragment>
        );
    }
}

if (document.getElementById('sponsorshipPayouts')) {
    let spon_id = document.getElementById('sponsorshipPayouts').getAttribute("data-spon-id");

    ReactDOM.render(<SponsorshipPayouts sponId={spon_id} />, document.getElementById('sponsorshipPayouts'));
}
