import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import Axios from 'axios';


export default class SponsorsList extends Component {
    constructor(props) {
        super(props);
        this.state = {
            sponId: this.props.sponId,
            sponsors: [],
            isLoading: true,
            requestSuccess: false,
            error: null,
        }
        this.getSponsors = this.getSponsors.bind(this);
    }

    componentDidMount() {
        this.getSponsors();
    }

    getSponsors() {
        this.setState({ isLoading: true });
        console.log("spon_id", this.state.sponId);
        Axios.get('/cms/getSponsorsList?spon_id=' + this.state.sponId).then(
            response => {
                const data = response.data;
                this.setState({
                    isLoading: false,
                    requestSuccess: true,
                    sponsors: data.sponsors,
                    error: null,
                });
            }
        ).catch(errors => {
            this.setState({
                isLoading: false,
                sponsors: [],
                error: errors.message,
                requestSuccess: false
            });
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
                                <h3 className="h3-responsive white-text">Sponsors</h3>
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
                                    <ul className="list-group">
                                        {this.state.sponsors.map((sponsor, i) => {
                                            return (
                                                <li key={i} className="list-group-item">
                                                    <div className="row">
                                                        <div className="col-2">
                                                            <img className="img-responsive btn-sm-rounded grey lighten-3" src={sponsor.user.profile.avatar_url} />
                                                        </div>
                                                        <div className="col-7">
                                                            <span style={{ fontSize: 18 }}>{sponsor.user.name}</span>
                                                            <br />
                                                            <span style={{ fontSize: 15 }}>{sponsor.user.email}<br />{sponsor.user.profile.phone_no}</span>
                                                        </div>
                                                        <div className="col-3 pt-1 align-text-right">
                                                            <span style={{ fontSize: 16 }}>{sponsor.units} Unit{sponsor.units > 1 ? 's' : null}</span>
                                                            {sponsor.has_received_returns ? <span className="badge badge-success">Returns Received</span> : null}
                                                        </div>
                                                    </div>
                                                </li>
                                            )
                                        })}
                                    </ul>
                                </div>
                            </div>
                        }
                    </div>
                }
            </React.Fragment>
        );
    }
}

if (document.getElementById('sponsorsList')) {
    let spon_id = document.getElementById('sponsorsList').getAttribute("data-spon-id");

    ReactDOM.render(<SponsorsList sponId={spon_id} />, document.getElementById('sponsorsList'));
}
